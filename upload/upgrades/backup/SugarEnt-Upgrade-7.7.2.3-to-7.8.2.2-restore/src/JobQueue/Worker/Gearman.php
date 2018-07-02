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

namespace Sugarcrm\Sugarcrm\JobQueue\Worker;

use Sugarcrm\Sugarcrm\JobQueue\Exception\RuntimeException;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;
use Sugarcrm\Sugarcrm\JobQueue\Serializer\SerializerInterface;

/**
 * Class Gearman
 * @package JobQueue
 */
class Gearman implements WorkerInterface
{
    /**
     * @var \GearmanWorker.
     */
    protected $worker;

    /**
     * @var int Timeout if there are no active fds (seconds).
     */
    protected $noActiveFdsTimeout = 5;

    /**
     * Storage for binding routes to handlers.
     * Since Gearman is not able to retrieve all registered handlers natively, we should store them here.
     * @var array
     */
    protected $handlers = array();

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param array $config Configuration parameters:
     * servers - A comma separated list of job servers in the format host:port. Empty string is 127.0.0.1:4730.
     * @param array $config
     * @param SerializerInterface $serializer
     * @throws RuntimeException
     */
    public function __construct(array $config, SerializerInterface $serializer)
    {
        if (!extension_loaded('gearman')) {
            throw new RuntimeException('The gearman extension is not loaded.');
        }
        $this->worker = new \GearmanWorker();
        $this->worker->addOptions(GEARMAN_WORKER_NON_BLOCKING);
        $this->worker->setTimeout(5000);

        $this->serializer = $serializer;

        if (!empty($config['servers'])) {
            $result = $this->worker->addServers($config['servers']);
        } else {
            $result = $this->worker->addServer();
        }
        if (!$result) {
            throw new RuntimeException('Cannot add gearman server.');
        }
    }

    /**
     * The function is manager's 'proxyHandler()'.
     * {@inheritdoc}
     */
    public function registerHandler($route, $function)
    {
        $envelope = function (\GearmanJob $gearmanJob) use ($function) {
            $workload = $this->getJob($gearmanJob);

            return call_user_func($function, $workload);
        };
        $this->handlers[$route] = $envelope;

        $this->worker->addFunction($route, $envelope);
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterHandler($route)
    {
        unset($this->handlers[$route]);
        $this->worker->unregister($route);
    }

    /**
     * {@inheritdoc}
     * @throws RuntimeException
     */
    public function work()
    {
        if (!$this->handlers) {
            throw new RuntimeException('No handlers registered.');
        }
        return $this->worker->work();
    }

    /**
     * {@inheritdoc}
     */
    public function wait()
    {
        $status = $this->worker->wait();
        if (!$status) {
            if ($this->worker->returnCode() === WorkerInterface::RETURN_CODE_NO_ACTIVE_FDS) {
                sleep($this->noActiveFdsTimeout);
                return $this->worker->wait();
            }
            if ($this->worker->returnCode() === WorkerInterface::RETURN_CODE_TIMEOUT) {
                return true;
            }
        }
        return $status;
    }

    /**
     * {@inheritdoc}
     */
    public function returnCode()
    {
        return $this->worker->returnCode();
    }

    /**
     * Convert gearman specific evelope object to workload.
     *
     * @param \GearmanJob $gearmanJob
     * @return WorkloadInterface
     */
    public function getJob(\GearmanJob $gearmanJob)
    {
        return $this->serializer->unserialize($gearmanJob->workload());
    }
}
