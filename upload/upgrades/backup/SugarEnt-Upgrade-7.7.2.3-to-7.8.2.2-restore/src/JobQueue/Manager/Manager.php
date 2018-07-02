<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\Sugarcrm\JobQueue\Manager;

use Aws\Common\Exception\RuntimeException;
use Sugarcrm\Sugarcrm\JobQueue\Client\ClientInterface;
use Sugarcrm\Sugarcrm\JobQueue\Client\Gearman as GearmanClient;
use Sugarcrm\Sugarcrm\JobQueue\Client\MessageQueue as MessageQueueClient;
use Sugarcrm\Sugarcrm\JobQueue\Client\Immediate as ImmediateClient;
use Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue\AdapterInterface;
use Sugarcrm\Sugarcrm\JobQueue\Dispatcher\DispatcherInterface;
use Sugarcrm\Sugarcrm\JobQueue\Dispatcher\Handler;
use Sugarcrm\Sugarcrm\JobQueue\Exception\LogicException;
use Sugarcrm\Sugarcrm\JobQueue\Exception\UnexpectedResolutionException;
use Sugarcrm\Sugarcrm\JobQueue\LockStrategy\CacheFile;
use Sugarcrm\Sugarcrm\JobQueue\LockStrategy\LockStrategyInterface;
use Sugarcrm\Sugarcrm\JobQueue\LockStrategy\Stub;
use Sugarcrm\Sugarcrm\JobQueue\Observer\Reflection;
use Sugarcrm\Sugarcrm\JobQueue\Observer\ObserverInterface;
use Sugarcrm\Sugarcrm\JobQueue\Observer\State;
use Sugarcrm\Sugarcrm\JobQueue\Runner\OD as ODRunner;
use Sugarcrm\Sugarcrm\JobQueue\Runner\Parallel;
use Sugarcrm\Sugarcrm\JobQueue\Runner\RunnerInterface;
use Sugarcrm\Sugarcrm\JobQueue\Runner\Standard;
use Sugarcrm\Sugarcrm\JobQueue\Worker\Gearman as GearmanWorker;
use Sugarcrm\Sugarcrm\JobQueue\Worker\MessageQueue as MessageQueueWorker;
use Sugarcrm\Sugarcrm\JobQueue\Worker\WorkerInterface;
use Sugarcrm\Sugarcrm\JobQueue\Workload\OD as ODWorkload;
use Sugarcrm\Sugarcrm\JobQueue\Workload\Workload;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;
use Sugarcrm\Sugarcrm\JobQueue\Adapter\AdapterRegistry;
use Sugarcrm\Sugarcrm\JobQueue\Handler\HandlerRegistry;
use Sugarcrm\Sugarcrm\JobQueue\Serializer\SerializerInterface;
use Sugarcrm\Sugarcrm\JobQueue\Serializer\Serializer;

/**
 * Class Manager
 * @package JobQueue
 */
class Manager implements ClientInterface, RunnerInterface
{
    /**
     * @var array $defaultConfig
     */
    protected $defaultConfig = array(
        'adapter' => 'Sugar',
        'runner' => 'Standard',
    );

    /**
     * @var array $systemHandlers Of system handlers.
     */
    protected $systemHandlers = array(
        'MassUpdateDemo' => 'Sugarcrm\Sugarcrm\JobQueue\Handler\MassUpdateDemo',
        'DeleteBeanDemo' => 'Sugarcrm\Sugarcrm\JobQueue\Handler\DeleteBeanDemo',
        'UpdateBeanDemo' => 'Sugarcrm\Sugarcrm\JobQueue\Handler\UpdateBeanDemo',
        'ExportListViewDemo' => 'Sugarcrm\Sugarcrm\JobQueue\Handler\ExportListViewDemo',
        'ExportToCSVDemo' => 'Sugarcrm\Sugarcrm\JobQueue\Handler\ExportToCSVDemo',
    );

    /**
     * @var array $systemAdapters Of system adapters.
     */
    protected $systemAdapters = array(
        // Gearman is a special case represents a real job server.
        'Gearman' => '',
        // Message Queue adapters.
        'Amazon_SQS' => 'Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue\AmazonSQS',
        'AMQP' => 'Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue\AMQP',
        'Sugar' => 'Sugarcrm\Sugarcrm\JobQueue\Adapter\MessageQueue\Sugar',
    );

    /**
     * @var HandlerRegistry
     */
    protected $handlerRegistry;

    /**
     * @var AdapterRegistry
     */
    protected $adapterRegistry;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var WorkerInterface
     */
    protected $worker;

    /**
     * @var \SplObjectStorage
     */
    protected $observer;

    /**
     * @var RunnerInterface
     */
    protected $runner;

    /**
     * @var \SugarLogger
     */
    protected $logger;

    /**
     * @var array $context Context the manager is called.
     */
    protected $context = array();

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var LockStrategyInterface
     */
    protected $lockStrategy;

    /**
     * Load default handlers and adapters.
     */
    public function __construct()
    {
        $this->logger = \LoggerManager::getLogger();
        $this->handlerRegistry = new HandlerRegistry();
        $this->adapterRegistry = new AdapterRegistry();
        $this->initHandlers();
        $this->initAdapters();
    }

    /**
     * Get client.
     *
     * @return ClientInterface
     * @throws LogicException
     */
    protected function getClient()
    {
        if ($this->client) {
            return $this->client;
        }

        $config = $this->getSystemConfig();
        $serializer = $this->getSerializer();

        if (empty($config['adapter'])) {
            throw new LogicException('Cannot setup client. Adapter is not found.');
        }
        if (strtolower($config['adapter']) == 'gearman' && isset($config['gearman'])) {
            $this->client = new GearmanClient($config['gearman'], $serializer);
        } elseif (strtolower($config['adapter']) == 'immediate') {
            $this->client = new ImmediateClient(array($this, 'proxyHandler'));
        } else {
            // Message queue client.
            $adapter = $this->getMessageQueueAdapter($config);
            if (!$adapter) {
                throw new LogicException("Cannot create a client, adapter {$config['adapter']} is not found.");
            }
            $this->client = new MessageQueueClient($adapter, $serializer);
        }

        return $this->client;
    }

    /**
     * Get worker.
     *
     * @return WorkerInterface
     * @throws LogicException
     */
    protected function getWorker()
    {
        if ($this->worker) {
            return $this->worker;
        }

        $config = $this->getSystemConfig();
        $serializer = $this->getSerializer();

        if (empty($config['adapter'])) {
            throw new LogicException('Cannot setup worker. Adapter is not found.');
        }
        if (strtolower($config['adapter']) == 'gearman' && isset($config['gearman'])) {
            $this->worker = new GearmanWorker($config['gearman'], $serializer);
        } elseif (strtolower($config['adapter']) == 'immediate') {
            throw new LogicException(
                'Worker is not needed to run immediate job - run is performed in ImmediateClient.'
            );
        } else {
            // Message queue worker.
            $adapter = $this->getMessageQueueAdapter($config);
            if (!$adapter) {
                throw new LogicException("Cannot create a worker, adapter {$config['adapter']} is not found.");
            }
            $this->worker = new MessageQueueWorker($adapter, $serializer);
        }

        return $this->worker;
    }

    /**
     * Get observer.
     *
     * @return \SplObjectStorage
     */
    protected function getObserver()
    {
        if ($this->observer) {
            return $this->observer;
        }
        $this->observer = new \SplObjectStorage();
        $this->observer->attach(new Reflection());
        if (!($this->getClient() instanceof ImmediateClient)) {
            $this->observer->attach(new State());
        }
        return $this->observer;
    }

    /**
     * Get runner.
     *
     * @return RunnerInterface
     */
    public function getRunner()
    {
        if ($this->runner) {
            return $this->runner;
        }
        $config = $this->getSystemConfig();
        $worker = $this->getWorker();
        $lock = $this->getLockStrategy();
        $this->logger->info('Creating worker runner.');

        if (!empty($config['od'])) {
            $this->runner = new ODRunner($worker, $lock);
        } elseif (isset($config['runner']) && $config['runner'] == 'parallel') {
            $this->runner = new Parallel($worker, $lock);
        } else {
            $this->runner = new Standard($worker, $lock);
        }
        return $this->runner;
    }

    /**
     * Get serializer.
     * @return SerializerInterface
     */
    protected function getSerializer()
    {
        if (!$this->serializer) {
            $this->serializer = new Serializer();
        }
        return $this->serializer;
    }

    /**
     * Get proper configuration data.
     * In OD mode internal configuration is used, otherwise module interface.
     *
     * @return array
     */
    protected function getSystemConfig()
    {
        // In OD params are taken from config, otherwise from interface.
        $od = \SugarConfig::getInstance()->get('job_queue.od');
        if (!empty($od)) {
            return \SugarConfig::getInstance()->get('job_queue');
        }
        $config = \BeanFactory::getBean('Administration')->getConfigForModule('SchedulersJobs', 'base');
        if (!empty($config)) {
            return $config;
        }
        return $this->defaultConfig;
    }

    /**
     * Get configured message queue adapter.
     * Because of message queues can work within unique exchange, or create a new queue, the special key
     * should be added here.
     *
     * @param array $config Message queue config.
     * @return AdapterInterface|null Configured adapter or null if an adapter cannot be found.
     * @throw LogicException If an adapter found but has no config.
     */
    protected function getMessageQueueAdapter($config)
    {
        $adapterConfig = array();
        $class = $this->adapterRegistry->get($config['adapter']);
        if (!$class) {
            return null;
        }
        if (isset($config[strtolower($config['adapter'])])) {
            $adapterConfig = $config[strtolower($config['adapter'])];
        }

        return new $class($adapterConfig);
    }

    /**
     * Return a specific dispatcher by name.
     *
     * @param string $handlerName In the register.
     * @return callable|null
     */
    protected function getDispatcher($handlerName)
    {
        $dispatcher = null;
        /**
         * @var string $name Handler name.
         * @var string $class Handler class.
         * @var DispatcherInterface $dispatcher Handler class.
         */
        extract($this->handlerRegistry->get($handlerName));
        return $dispatcher;
    }

    /**
     * Return a specific lock strategy.
     *
     * @return LockStrategyInterface
     */
    protected function getLockStrategy()
    {
        if ($this->lockStrategy) {
            return $this->lockStrategy;
        }
        $config = $this->getSystemConfig();
        if (!empty($config['od'])) {
            $this->lockStrategy = new Stub();
        } else {
            $this->lockStrategy = new CacheFile();
        }
        return $this->lockStrategy;
    }

    /**
     * Create and return instance of Workload.
     *
     * @param string $handlerName
     * @param mixed $data
     * @param array $attributes
     * @return WorkloadInterface instance of workload adapter.
     */
    public function createWorkload($handlerName, $data, array $attributes = array())
    {
        $config = $this->getSystemConfig();
        if (!empty($config['od'])) {
            return new ODWorkload($handlerName, $data, $attributes);
        }
        return new Workload($handlerName, $data, $attributes);
    }

    /**
     * Start running. Endpoint to start manager.
     */
    public function run()
    {
        if (!count($this->handlerRegistry)) {
            throw new LogicException('No handlers found.');
        }
        $this->registerHandlersInWorker();
        $this->getRunner()->run();
    }

    /**
     * Register system handler in configured worker with proxy method.
     */
    protected function registerHandlersInWorker()
    {
        foreach ($this->handlerRegistry as $params) {
            $workload = $this->createWorkload($params['name'], array());
            $this->getWorker()->registerHandler($workload->getRoute(), array($this, 'proxyHandler'));
        }
    }

    /**
     * Kill all the processes started by another instance of manager by invalidating its lock.
     */
    public function stop()
    {
        // Override lock to kill running managers.
        $this->getLockStrategy()->setLock(time());
    }

    /**
     * Collect system adapters into adapter registry.
     * Currently message queue adapters are supported (implement AdapterInterface).
     */
    protected function initAdapters()
    {
        foreach ($this->systemAdapters as $name => $class) {
            $this->adapterRegistry->add($name, $class);
        }
    }

    /**
     * Load handler registry and add system handlers.
     */
    protected function initHandlers()
    {
        foreach ($this->systemHandlers as $name => $class) {
            $this->registerHandler($name, $class);
        }
    }

    /**
     * Proxy method to handle jobs.
     * This method is called each time when we need handle some job.
     *
     * @param WorkloadInterface $workload
     * @return string Resolution.
     */
    public function proxyHandler($workload)
    {
        $resolution = null;
        $handlerName = $workload->getHandlerName();
        $dispatcher = $this->getDispatcher($handlerName);
        if (!$dispatcher) {
            $this->logger->error("The handler {$handlerName} is not registered.");
            return \SchedulersJob::JOB_FAILURE;
        }
        $callable = $dispatcher->dispatch();

        try {
            foreach ($this->getObserver() as $observer) {
                $observer->onRun($workload);
            }
        } catch (\Exception $ex) {
            $this->logger->error("Killed by observer: {$ex->getMessage()}");
            $resolution = \SchedulersJob::JOB_FAILURE;

            if ($ex instanceof UnexpectedResolutionException) {
                $resolution = $ex->getResolution();
            }
        }

        try {
            if (!$resolution) {
                $resolution = call_user_func($callable, $workload);
            }
        } catch (\Exception $ex) {
            $this->logger->error("Cannot run the handler {$handlerName}: {$ex->getMessage()}");
            $resolution = \SchedulersJob::JOB_FAILURE;
        }
        foreach ($this->getObserver() as $observer) {
            $observer->onResolve($workload, $resolution);
        }

        return $resolution;
    }

    /**
     * Create a job using case-insensitive handler name.
     *
     * @param string $name
     * @param array $arguments
     * @return WorkloadInterface
     * @throws RuntimeException
     */
    public function __call($name, $arguments)
    {
        $handlerParams = $this->handlerRegistry->get($name);
        if (!$handlerParams) {
            throw new RuntimeException("The handler '{$name}' is not registered.");
        }
        $class = $handlerParams['class'];
        $attributes = array();
        $attributes['fallible'] = defined("{$class}::FALLIBLE") ? constant("{$class}::FALLIBLE") : false;
        $attributes['rerun'] = defined("{$class}::RERUN") ? constant("{$class}::RERUN") : false;
        // To validate handler creating. Skip for subtasks.
        if (!$this->context) {
            $handlerObj = new \ReflectionClass($class);
            $handlerObj->newInstanceArgs($arguments);
        }
        $workload = $this->createWorkload($handlerParams['name'], $arguments, $attributes);
        $this->addJob($workload);

        return $workload;
    }

    /**
     * Attach observer.
     * {@inheritdoc}
     */
    public function addJob(WorkloadInterface $workload)
    {
        $workload->setAttribute('context', $this->context);
        // To check client initializing.
        $client = $this->getClient();
        foreach ($this->getObserver() as $observer) {
            $observer->onAdd($workload);
        }
        $client->addJob($workload);
    }

    /**
     * Shutdown handler.
     */
    public function shutdownHandler()
    {
        $this->getRunner()->shutdownHandler();
    }

    /**
     * Register a new observer in manager.
     *
     * @param ObserverInterface $observer
     */
    public function registerObserver(ObserverInterface $observer)
    {
        $this->getObserver()->attach($observer);
    }

    /**
     * Register a new handler.
     *
     * @param string $name Handler name.
     * @param string $class Full class name with namespace.
     *
     * @throws LogicException
     */
    public function registerHandler($name, $class)
    {
        if (!class_exists($class)) {
            throw new LogicException('Handler should be a class.');
        }
        $interfaces = class_implements($class);
        if (!in_array('Sugarcrm\Sugarcrm\JobQueue\Handler\RunnableInterface', $interfaces)) {
            throw new LogicException('Handler should implement RunnableInterface.');
        }
        $dispatcher = new Handler($class);
        $this->handlerRegistry->add($name, $class, $dispatcher);
    }

    /**
     * Register a new adapter.
     *
     * @param string $name Adapter name.
     * @param string $class Full class name with namespace.
     */
    public function registerAdapter($name, $class)
    {
        $this->adapterRegistry->add($name, $class);
    }

    /**
     * Set a context for manager.
     *
     * @param array $context
     */
    public function setContext(array $context)
    {
        $this->context = $context;
    }

    /**
     * Get registered handler.
     *
     * @param $name
     * @return array|null
     */
    public function getRegisteredHandler($name)
    {
        return $this->handlerRegistry->get($name);
    }
}
