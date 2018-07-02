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

namespace Sugarcrm\Sugarcrm\JobQueue\Dispatcher;

use Sugarcrm\Sugarcrm\JobQueue\Exception\InvalidArgumentException;
use Sugarcrm\Sugarcrm\JobQueue\Handler\SubtaskCapableInterface;
use Sugarcrm\Sugarcrm\JobQueue\Manager\Manager;
use Sugarcrm\Sugarcrm\JobQueue\Workload\WorkloadInterface;

/**
 * Class Handler
 * @package JobQueue
 */
class Handler implements DispatcherInterface
{
    /**
     * @var string $class
     */
    protected $class;

    /**
     * Should implement the Sugarcrm\Sugarcrm\JobQueue\Handler\RunnableInterface interface.
     * @param string $className Handler class.
     * @throws InvalidArgumentException
     */
    public function __construct($className)
    {
        if (class_exists($className)) {
            $interfaces = class_implements($className);
            if (!in_array('Sugarcrm\Sugarcrm\JobQueue\Handler\RunnableInterface', $interfaces)) {
                throw new InvalidArgumentException('Handler should implement RunnableInterface.');
            }
        } else {
            throw new InvalidArgumentException('Handler should be a class.');
        }
        $this->class = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch()
    {
        $className = $this->class;
        return function (WorkloadInterface $workload) use ($className) {
            $reflector = new \ReflectionClass($className);
            $handler = $reflector->newInstanceArgs($workload->getData());

            // The interface populates the $client property with ClientInterface for creating child tasks in context.
            if ($handler instanceof SubtaskCapableInterface && property_exists($handler, 'client')) {
                $manager = new Manager();
                $manager->setContext($workload->getAttributes());

                $property = $reflector->getProperty('client');
                $property->setAccessible(true);
                $property->setValue($handler, $manager);
            }
            try {
                return $handler->run();
            } catch (\Exception $ex) {
                \LoggerManager::getLogger()->error($reflector->getName() . ' error: ' . $ex->getMessage());
                return \SchedulersJob::JOB_FAILURE;
            }
        };
    }
}
