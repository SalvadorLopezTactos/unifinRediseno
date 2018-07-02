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

declare(ticks = 1);

/**
 * Class Parallel
 * @package JobQueue
 */
class Parallel extends AbstractRunner
{
    /**
     * @var int
     * The PID of the running process. Set for parent and child processes.
     */
    protected $pid = 0;

    /**
     * The PID of the parent process, when running in the forked helper.
     */
    protected $parentPid = 0;

    /**
     * PID of validation process.
     */
    protected $validationPid = 0;

    /**
     * @var bool Boolean value that determines if the running code is the parent or a child.
     */
    protected $isParent = true;

    /**
     * @var bool
     * When forking helper children, the parent waits for a signal
     * from them to continue doing anything.
     */
    protected $waitForSignal = false;

    /**
     * @var int
     * The timestamp when the signal was received to stop working.
     */
    protected $stopTime = 0;

    /**
     * @var bool
     * If true, the worker code directory is checked for updates and workers
     * are restarted automatically.
     */
    protected $checkCode = false;

    /**
     * @var int
     * Timeout to check new code in workers (seconds).
     */
    protected $checkCodeTimeout = 10;

    /**
     * @var int
     * Holds the last timestamp of when the code was checked for updates.
     */
    protected $lastCheckTime = 0;

    /**
     * @var array
     * The array of running child processes.
     */
    protected $children = array();

    /**
     * @var int
     * Number of workers that do any job.
     */
    protected $workersCount = 3;

    /**
     * @var int
     * Max time to running main process (seconds).
     */
    protected $mainMaxRuntime = 3600;

    /**
     * +/- number of minutes workers will delay before restarting
     * this prevents all your workers from restarting at the same
     * time which causes a connection stampeded on your daemons
     * So, a maxRuntime of 3600 and workerRestartDelay of 600 means
     * a worker will self restart between 3600 and 4200 seconds after
     * it is started.
     *
     * This does not affect the time the parent process waits on children
     * when shutting down.
     */
    protected $workerRestartDelay = 600;

    /**
     * Array of setting for a route to follow code changes, priority, etc.
     * Will be implemented in future.
     * @var array [route => ['path', 'count', 'dedicated', 'priority'], ...]
     * @throws RuntimeException
     */
    protected $handlers = array();

    /**
     * Check possibility to run in parallel mode, setup posix specific parameters.
     * {@inheritdoc}
     */
    public function __construct(WorkerInterface $worker, LockStrategyInterface $lock)
    {
        if (!extension_loaded('posix')) {
            throw new RuntimeException('The posix PHP extension is not loaded.');
        }

        if (!extension_loaded('pcntl')) {
            throw new RuntimeException('The pcntl PHP extension is not loaded.');
        }

        parent::__construct($worker, $lock);

        $this->pid = getmypid();

        $this->registerTicks();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->logger->info("Manager has been started with pid: {$this->pid}");
        $this->acquireLock();
        $this->startValidationProcess();
        $this->bootstrap();
        $this->processLoop();

        /**
         * Kill the validation process if it is running.
         */
        if (isset($this->validationPid)) {
            posix_kill($this->validationPid, SIGKILL);
        }
    }

    /**
     * Bootstap a set of workers and any vars that need to be set.
     */
    protected function bootstrap()
    {
        /**
         * Start workers that handle all routes.
         */
        if (!empty($this->workersCount) && is_int($this->workersCount)) {
            for ($i = 0; $i < $this->workersCount; $i++) {
                $this->startWorkerProcess();
            }
        }

        /**
         * Set the last code check time to now since we just loaded all the code.
         */
        $this->lastCheckTime = time();
    }

    /**
     * Main processing loop for the parent process.
     */
    protected function processLoop()
    {
        $start = time();

        while (!$this->stopWork || count($this->children)) {

            $status = null;

            /**
             * Check for exited children
             */
            $exited = pcntl_wait($status, WNOHANG);

            /**
             * We run other children, make sure this is a worker.
             */
            if (isset($this->children[$exited])) {
                /**
                 * If they have exited, remove them from the children array
                 * If we are not stopping work, start another in its place
                 */
                if ($exited) {
                    unset($this->children[$exited]);
                    $code = pcntl_wexitstatus($status);
                    $this->logger->error(
                        sprintf(
                            'Child %s exited with error code of %s',
                            $exited,
                            $code
                        )
                    );
                    if (!$this->stopWork) {
                        $this->logger->info('Restart child process');
                        $this->startWorkerProcess();
                    }
                }
            }

            if (!$this->isWorkProcessActual()) {
                $this->stopWork = true;
            }

            if ($this->stopWork && time() - $this->stopTime > 60) {
                $this->logger->info(sprintf('Children have not exited, killing.'));
                $this->stopChildren(SIGKILL);
            } else {
                /**
                 *  If any children have been running 150% of max run time, forcibly terminate them.
                 */
                if (!empty($this->children)) {
                    foreach ($this->children as $pid => $child) {
                        if (!empty($child['start_time'])
                            && time() - $child['start_time'] > $this->maxRuntime * 1.5
                        ) {
                            $this->logger->info(
                                "Child  has been running too long. Forcibly killing process."
                            );
                            posix_kill($pid, SIGKILL);
                        }
                    }
                }
            }

            /**
             * Php will eat up your cpu if you don't have this.
             */
            usleep(50000);

            /**
             * Check the running time of the main process (manager).
             * If it has been too long, stop working.
             */
            if ($this->mainMaxRuntime > 0 && time() - $start > $this->mainMaxRuntime) {
                $this->stopWork = true;
            }
        }
        if (!empty($this->pid)) {
            posix_kill($this->pid, SIGUSR1);
        }
    }

    /**
     * Registers the process signal listeners.
     */
    protected function registerTicks($parent = true)
    {
        if ($parent) {
            $this->logger->info('Registering signals for parent');
            pcntl_signal(SIGTERM, array($this, 'handleSignal'));
            pcntl_signal(SIGINT, array($this, 'handleSignal'));
            pcntl_signal(SIGUSR1, array($this, 'handleSignal'));
            pcntl_signal(SIGUSR2, array($this, 'handleSignal'));
            pcntl_signal(SIGCONT, array($this, 'handleSignal'));
            pcntl_signal(SIGHUP, array($this, 'handleSignal'));
        } else {
            $this->logger->info('Registering signals for child');
            if (!pcntl_signal(SIGTERM, array($this, 'handleSignal'))) {
                exit();
            }
        }
    }

    /**
     * Handles signals.
     */
    public function handleSignal($signo)
    {
        static $termCount = 0;

        if (!$this->isParent) {
            $this->stopWork = true;
        } else {

            switch ($signo) {
                case SIGUSR1:
                    // No worker files could be found
                    break;
                case SIGUSR2:
                    // Error validating worker functions
                    break;
                case SIGCONT:
                    $this->waitForSignal = false;
                    break;
                case SIGINT:
                case SIGTERM:
                    $this->logger->info('Shutting down...');
                    $this->stopWork = true;
                    $this->stopTime = time();
                    $termCount++;
                    if ($termCount < 5) {
                        $this->stopChildren();
                    } else {
                        $this->stopChildren(SIGKILL);
                    }
                    break;
                case SIGHUP:
                    $this->logger->info('Restarting children.');
                    $this->stopChildren();
                    break;
                default:
                    $this->logger->info("Unknown signal {$signo}.");
            }
        }

    }

    /**
     * Stops all running children.
     * @param int $signal
     */
    protected function stopChildren($signal = SIGTERM)
    {
        $this->logger->info('Stopping children');

        foreach ($this->children as $pid => $child) {
            $this->logger->info("Stopping child {$pid}");
            posix_kill($pid, $signal);
        }
    }

    /**
     * Forks the process and runs the given method. The parent then waits
     * for the child process to signal back that it can continue.
     */
    protected function startValidationProcess()
    {
        $this->waitForSignal = true;

        /**
         * Connection should be closed before fork.
         */
        \DBManagerFactory::disconnectAll();

        $pid = pcntl_fork();

        switch ($pid) {
            case 0:
                // Restore database connection after fork.
                \DBManagerFactory::getInstance();

                $this->isParent = false;
                $this->parentPid = $this->pid;
                $this->pid = getmypid();
                $this->validateWorkers();
                break;
            case -1:
                $this->logger->fatal('Failed to fork validation process.');
                $this->stopWork = true;
                break;
            default:

                // Restore database connection after fork.
                \DBManagerFactory::getInstance();

                $this->logger->info("Helper forked with pid {$pid}");

                $this->validationPid = $pid;
                while ($this->waitForSignal && !$this->stopWork) {
                    usleep(5000);
                    pcntl_waitpid($pid, $status, WNOHANG);

                    if (pcntl_wifexited($status) && $status) {
                        $this->logger->error("Helper child exited with non-zero exit code {$status}.");
                        exit(1);
                    }
                }
                break;
        }
    }

    /**
     * Forked method that validates the worker code and checks it if desired.
     */
    protected function validateWorkers()
    {
        /**
         * Since we got here, all must be ok, send a CONTINUE
         */
        $this->logger->info("Helper is running. Sending continue to parent {$this->parentPid}.");
        posix_kill($this->parentPid, SIGCONT);

        if ($this->checkCode) {
            $this->logger->info('Running loop to check for new code');
            $lastCheckTime = 0;
            while (1) {
                $maxTime = 0;
                foreach ($this->handlers as $route => $settings) {
                    if (!$settings['path']) {
                        continue;
                    }
                    clearstatcache();
                    $mtime = filemtime($settings['path']);
                    $maxTime = max($maxTime, $mtime);

                    $this->logger->info(
                        sprintf(
                            '%s - %s %s',
                            $settings['path'],
                            $mtime,
                            $lastCheckTime
                        )
                    );

                    if ($lastCheckTime != 0 && $mtime > $lastCheckTime) {
                        $this->logger->info(
                            sprintf(
                                'New code found in %s. Sending SIGHUP',
                                $settings['path']
                            )
                        );
                        posix_kill($this->parentPid, SIGHUP);
                        break;
                    }
                }
                $lastCheckTime = $maxTime;
                sleep($this->checkCodeTimeout);
            }
        } else {
            exit();
        }
    }

    /**
     * Starts new process for workers.
     */
    protected function startWorkerProcess()
    {
        /**
         * Connection should be closed before fork.
         */
        \DBManagerFactory::disconnectAll();

        $pid = pcntl_fork();

        switch ($pid) {
            case 0:

                // Restore database connection after fork.
                \DBManagerFactory::getInstance();

                $this->isParent = false;
                $this->registerTicks(false);
                $this->pid = getmypid();

                if ($this->workerRestartDelay > 0) {
                    $this->maxRuntime = (int)rand(
                        $this->maxRuntime,
                        $this->maxRuntime + $this->workerRestartDelay
                    );
                    $this->logger->info(
                        sprintf(
                            'Adjusted max run time to %s seconds',
                            $this->maxRuntime
                        )
                    );
                }

                $this->startWorker();
                $this->logger->info(sprintf('Child exiting'));
                exit();
                break;
            case -1:
                $this->logger->info(sprintf('Could not fork'));
                $this->stopWork = true;
                $this->stopChildren();
                break;
            default:
                // Restore database connection after fork.
                \DBManagerFactory::getInstance();

                $this->children[$pid] = array(
                    'start_time' => time(),
                );
        }
    }

    /**
     * Updates lock in parent process.
     * Disabled in child process.
     * {@inheritdoc}
     */
    public function updateLock()
    {
        if (!$this->isParent) {
            return;
        }
        parent::updateLock();
    }

    /**
     * Check parent process actuality.
     * Child process is always actual because killed by parent.
     * {@inheritdoc}
     */
    public function isWorkProcessActual()
    {
        if (!$this->isParent) {
            return true;
        }
        return parent::isWorkProcessActual();
    }

    /**
     * Removes runner lock on shutdown.
     * Affect parent process only.
     */
    public function shutdownHandler()
    {
        if ($this->isParent) {
            parent::shutdownHandler();
        }
    }
}
