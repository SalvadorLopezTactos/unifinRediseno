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

namespace Sugarcrm\Sugarcrm\JobQueue\Runner;

use Sugarcrm\Sugarcrm\JobQueue\Exception\RuntimeException;
use Sugarcrm\Sugarcrm\JobQueue\LockStrategy\LockStrategyInterface;
use Sugarcrm\Sugarcrm\JobQueue\Worker\WorkerInterface;

/**
 * Class AbstractRunner
 * @package JobQueue
 */
abstract class AbstractRunner implements RunnerInterface
{
    /**
     * @var bool
     * When true, workers will stop look for jobs.
     * If there are child pocesses the parent process will kill off all running children.
     */
    protected $stopWork = false;

    /**
     * @var int
     * Max time to run (seconds). Default is 3600.
     */
    protected $maxRuntime = 3600;

    /**
     * @var int Seconds.
     * Update lock cycle time.
     */
    protected $lockUpdateCycle = 60;

    /**
     * Lifetime of lock value in seconds.
     * Default is 5 minutes.
     *
     * @var int
     */
    protected $lockLifetime = 300;

    /**
     * @var int
     * Timeout if there are no active jobs (seconds).
     */
    protected $noJobsTimeout = 5;

    /**
     * @var \SugarLogger
     */
    protected $logger;

    /**
     * @var WorkerInterface
     */
    protected $worker;

    /**
     * @var LockStrategyInterface
     */
    protected $lock;

    /**
     * @var int $lockValue Runner's lock value.
     */
    protected $lockValue;

    /**
     * @param WorkerInterface $worker
     * @param LockStrategyInterface $lock
     */
    public function __construct(WorkerInterface $worker, LockStrategyInterface $lock)
    {
        $this->logger = \LoggerManager::getLogger();
        $this->worker = $worker;
        $this->lock = $lock;
        \TimeDate::getInstance()->allow_cache = false;
    }

    /**
     * Removes runner lock on shutdown.
     */
    public function shutdownHandler()
    {
        if ($this->lock->hasLock()) {
            $lockTime = $this->lock->getLock();
            if ($lockTime != $this->lockValue) {
                return;
            }
            $this->lock->clearLock();
        }
    }

    /**
     * Lock the process using a lock strategy.
     * @throws RuntimeException
     */
    public function acquireLock()
    {
        if (!$this->isWorkProcessActual()) {
            $message = 'Another instance is already locked process.';
            \LoggerManager::getLogger()->fatal($message);
            throw new RuntimeException($message);
        }
        $this->updateLock();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function run();

    /**
     * Start handling workers.
     */
    public function startWorker()
    {
        $startTime = time();

        while (!$this->stopWork) {

            if ($this->worker->work() ||
                $this->worker->returnCode() === WorkerInterface::RETURN_CODE_IO_WAIT ||
                $this->worker->returnCode() === WorkerInterface::RETURN_CODE_NO_JOBS
            ) {
                // Lock gone or previous work was too long.
                if (!$this->isWorkProcessActual()) {
                    $this->stopWork = true;
                    continue;
                }
                if ($this->worker->returnCode() === WorkerInterface::RETURN_CODE_SUCCESS) {
                    continue;
                }

                if (!$this->worker->wait()) {
                    $this->stopWork = true;
                    continue;
                }
            }

            if (!$this->isWorkProcessActual()) {
                $this->stopWork = true;
                continue;
            }

            /**
             * Check the running time of the current process.
             * If it has been too long, stop working.
             */
            if ($this->maxRuntime > 0 && time() - $startTime > $this->maxRuntime) {
                $this->stopWork = true;
                continue;
            }

            /**
             * Update lock time every minute.
             */
            if ((time() - $this->lockValue) > $this->lockUpdateCycle) {
                $this->updateLock();
            }

            if ($this->worker->returnCode() === WorkerInterface::RETURN_CODE_NO_JOBS ||
                $this->worker->returnCode() === WorkerInterface::RETURN_CODE_TIMEOUT
            ) {
                $this->noJobsHandler();
            }
        }
        $this->shutdownHandler();
    }

    /**
     * Check work process actuality.
     *
     * @return bool
     */
    public function isWorkProcessActual()
    {
        if (!$this->lock->isActual()) {
            return (time() - $this->lock->getLock()) > $this->lockLifetime;
        }
        return true;
    }

    /**
     * Save new lock value for runner.
     */
    public function updateLock()
    {
        $this->lockValue = time();
        $this->lock->setLock($this->lockValue);
    }

    /**
     * Handle no jobs case.
     */
    protected function noJobsHandler()
    {
        if (!empty($this->noJobsTimeout)) {
            sleep($this->noJobsTimeout);
        }
    }
}
