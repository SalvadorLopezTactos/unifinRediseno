<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Sugarcrm\Sugarcrm\DependencyInjection\Container;
use Sugarcrm\Sugarcrm\Security\Context;
use Sugarcrm\Sugarcrm\Security\Subject\CronJob;

/**
 * Job queue job
 * @api
 */
class SchedulersJob extends Basic
{
    public const JOB_STATUS_QUEUED = 'queued';
    public const JOB_STATUS_RUNNING = 'running';
    public const JOB_STATUS_DONE = 'done';

    // Resolutions.
    public const JOB_PENDING = 'queued';
    public const JOB_PARTIAL = 'partial';
    public const JOB_SUCCESS = 'success';
    public const JOB_FAILURE = 'failure';
    public const JOB_RUNNING = 'running';
    public const JOB_CANCELLED = 'cancelled';

    // schema attributes
    public $id;
    public $name;
    public $deleted;
    public $date_entered;
    public $date_modified;
    public $scheduler_id;
    public $execute_time; // when to execute
    public $status;
    public $resolution;
    public $message;
    public $target; // URL or function name
    public $data; // Data set
    public $requeue; // Requeue on failure?
    public $retry_count;
    public $failure_count;
    /**
     * @depricated
     * @var int
     */
    public $job_delay = 0; // Frequency to run it
    public $assigned_user_id; // User under which the task is running
    public $client; // Client ID that owns this job
    public $execute_time_db;
    public $percent_complete; // how much of the job is done
    public $module;
    public $fallible;
    public $rerun;
    public $interface = true;

    /**
     * The group that the job belongs to
     *
     * @var String
     */
    public $job_group;

    // standard SugarBean child attrs
    public $table_name = 'job_queue';
    public $object_name = 'SchedulersJob';
    public $module_dir = 'SchedulersJobs';
    public $new_schema = true;
    public $process_save_dates = true;
    // related fields
    public $job_name;  // the Scheduler's 'name' field
    public $job;       // the Scheduler's 'job' field
    // object specific attributes
    public $user; // User object
    public $scheduler; // Scheduler parent
    public $min_interval = 30; // minimal interval for job reruns
    protected $job_done = true;
    protected $old_user;

    /**
     * Job constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->disable_row_level_security = true;
        if (!empty($GLOBALS['sugar_config']['jobs']['min_retry_interval'])) {
            $this->min_interval = $GLOBALS['sugar_config']['jobs']['min_retry_interval'];
        }
    }

    public function check_date_relationships_load()
    {
        // Hack to work around the mess with dates being auto-converted to user format on retrieve
        $this->execute_time_db = $this->db->fromConvert($this->execute_time, 'datetime');
        parent::check_date_relationships_load();
    }

    /**
     * handleDateFormat
     *
     * This function handles returning a datetime value.  It allows a user instance to be passed in, but will default to the
     * user member variable instance if none is found.
     *
     * @param string $date String value of the date to calculate, defaults to 'now'
     * @param object $user The User instance to use in calculating the time value, if empty, it will default to user member variable
     * @param boolean $user_format Boolean indicating whether or not to convert to user's time format, defaults to false
     *
     * @return string Formatted datetime value
     */
    public function handleDateFormat($date = 'now', $user = null, $user_format = false)
    {
        global $timedate;

        if (!isset($timedate) || empty($timedate)) {
            $timedate = new TimeDate();
        }

        // get user for calculation
        $user = (empty($user)) ? $this->user : $user;

        if ($date == 'now') {
            $dbTime = $timedate->asUser($timedate->getNow(), $user);
        } else {
            $dbTime = $timedate->asUser($timedate->fromString($date, $user), $user);
        }

        // if $user_format is set to true then just return as th user's time format, otherwise, return as database format
        return $user_format ? $dbTime : $timedate->fromUser($dbTime, $user)->asDb();
    }


    ///////////////////////////////////////////////////////////////////////////
    ////	SCHEDULERSJOB HELPER FUNCTIONS

    /**
     * This function takes a passed URL and cURLs it to fake multi-threading with another httpd instance
     * @param   $job        String in URI-clean format
     * @param   $timeout    Int value in secs for cURL to timeout. 30 default.
     */
    public function fireUrl($job, $timeout = 30)
    {
        // TODO: figure out what error is thrown when no more apache instances can be spun off
        // cURL inits
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $job); // set url
        curl_setopt($ch, CURLOPT_FAILONERROR, true); // silent failure (code >300);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // do not follow location(); inits - we always use the current
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);  // not thread-safe
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return into a variable to continue program execution
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // never times out - bad idea?
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // 5 secs for connect timeout
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);  // open brand new conn
        curl_setopt($ch, CURLOPT_HEADER, true); // do not return header info with result
        curl_setopt($ch, CURLOPT_NOPROGRESS, true); // do not have progress bar
        $urlparts = parse_url($job);
        if (empty($urlparts['port'])) {
            if ($urlparts['scheme'] == 'https') {
                $urlparts['port'] = 443;
            } else {
                $urlparts['port'] = 80;
            }
        }
        curl_setopt($ch, CURLOPT_PORT, $urlparts['port']); // set port as reported by Server
        //TODO make the below configurable
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // most customers will not have Certificate Authority account
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // most customers will not have Certificate Authority account

        curl_setopt($ch, CURLOPT_NOSIGNAL, true); // ignore any cURL signals to PHP (for multi-threading)
        $result = curl_exec($ch);
        $cInfo = curl_getinfo($ch);     //url,content_type,header_size,request_size,filetime,http_code
        //ssl_verify_result,total_time,namelookup_time,connect_time
        //pretransfer_time,size_upload,size_download,speed_download,
        //speed_upload,download_content_length,upload_content_length
        //starttransfer_time,redirect_time
        if (curl_errno($ch)) {
            $this->errors .= curl_errno($ch) . "\n";
        }
        curl_close($ch);

        if ($result !== false && $cInfo['http_code'] < 400) {
            $GLOBALS['log']->debug("----->Firing was successful: $job");
            $GLOBALS['log']->debug('----->WTIH RESULT: ' . strip_tags($result) . ' AND ' . strip_tags(print_r($cInfo, true)));
            return true;
        } else {
            $GLOBALS['log']->fatal("Job failed: $job");
            return false;
        }
    }
    ////	END SCHEDULERSJOB HELPER FUNCTIONS
    ///////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////
    ////	STANDARD SUGARBEAN OVERRIDES
    /**
     * This function gets DB data and preps it for ListViews
     */
    public function get_list_view_data($filter_fields = [])
    {
        global $mod_strings;

        $temp_array = $this->get_list_view_array();
        $temp_array['JOB_NAME'] = $this->job_name;
        $temp_array['JOB'] = $this->job;

        return $temp_array;
    }

    /** method stub for future customization
     *
     */
    public function fill_in_additional_list_fields()
    {
        $this->fill_in_additional_detail_fields();
    }


    /**
     * Mark this job as failed
     * @param string $message
     */
    public function failJob($message = null)
    {
        return $this->resolveJob(self::JOB_FAILURE, $message);
    }

    /**
     * Mark this job as success
     * @param string $message
     */
    public function succeedJob($message = null)
    {
        return $this->resolveJob(self::JOB_SUCCESS, $message);
    }

    /**
     * Called if job failed but will be retried
     */
    public function onFailureRetry()
    {
        // TODO: what we do if job fails, notify somebody?
        $this->call_custom_logic('job_failure_retry');
    }

    /**
     * Called if job has failed and will not be retried
     */
    public function onFinalFailure()
    {
        // TODO: what we do if job fails, notify somebody?
        $this->call_custom_logic('job_failure');
    }

    /**
     * Resolve job as success or failure
     * @param string $resolution One of JOB_ constants that define job status
     * @param string $message
     * @return bool
     */
    public function resolveJob($resolution, $message = null)
    {
        $GLOBALS['log']->info("Resolving job {$this->id} as $resolution: $message");
        if ($resolution == self::JOB_FAILURE) {
            $this->failure_count++;
            if ($this->requeue && $this->retry_count > 0) {
                // retry failed job
                $this->status = self::JOB_STATUS_QUEUED;
                if ($this->job_delay < $this->min_interval) {
                    $this->job_delay = $this->min_interval;
                }
                $this->execute_time = $GLOBALS['timedate']->getNow()->modify("+{$this->job_delay} seconds")->asDb();
                $this->retry_count--;
                $GLOBALS['log']->info("Will retry job {$this->id} at {$this->execute_time} ($this->retry_count)");
                $this->onFailureRetry();
            } else {
                // final failure
                $this->status = self::JOB_STATUS_DONE;
                $this->onFinalFailure();
            }
        } else {
            $this->status = self::JOB_STATUS_DONE;
        }
        $this->addMessages($message);
        $this->resolution = $resolution;
        $this->save();
        if ($this->status == self::JOB_STATUS_DONE && $this->resolution == self::JOB_SUCCESS) {
            $this->updateSchedulerSuccess();
        }
        return true;
    }

    /**
     * Update schedulers table on job success
     */
    protected function updateSchedulerSuccess()
    {
        if (empty($this->scheduler_id)) {
            return;
        }
        $this->db->query("UPDATE schedulers SET last_run={$this->db->now()} WHERE id=" . $this->db->quoted($this->scheduler_id));
    }

    /**
     * Assemle job messages
     * Takes messages in $this->message, errors & $message and assembles them into $this->message
     * @param string $message
     */
    protected function addMessages($message)
    {
        if (!empty($this->errors)) {
            $this->message .= $this->errors;
            $this->errors = '';
        }
        if (!empty($message)) {
            $this->message .= "$message\n";
        }
    }

    /**
     * Rerun this job again
     * @param string $message
     * @param string $delay how long to delay (default is job's delay)
     * @return bool
     */
    public function postponeJob($message = null, $delay = null)
    {
        $this->status = self::JOB_STATUS_QUEUED;
        $this->addMessages($message);
        $this->resolution = self::JOB_PARTIAL;
        if (empty($delay)) {
            $delay = intval($this->job_delay);
        }
        $this->execute_time = $GLOBALS['timedate']->getNow()->modify("+$delay seconds")->asDb();
        $GLOBALS['log']->info("Postponing job {$this->id} to {$this->execute_time}: $message");

        $this->save();
        return true;
    }

    /**
     * Delete a job
     * @see SugarBean::doMarkDeleted()
     */
    protected function doMarkDeleted(): void
    {
        $query = "DELETE FROM {$this->table_name} WHERE id = ? ";
        $conn = $this->db->getConnection();
        $conn->executeStatement($query, [$this->id]);
    }

    /**
     * Shutdown handler to be called if something breaks in the middle of the job
     */
    public function unexpectedExit()
    {
        if (!$this->job_done) {
            // Job wasn't properly finished, fail it
            $this->resolveJob(self::JOB_FAILURE, translate('ERR_FAILED', 'SchedulersJobs'));
        }
    }

    /**
     * Run the job by ID
     * @param string $id
     * @param string $client Client that is trying to run the job
     * @return bool|string true on success, false on job failure, error message on failure to run
     */
    public static function runJobId($id, $client)
    {
        $job = new self();
        $job->retrieve($id);
        if (empty($job->id)) {
            $GLOBALS['log']->fatal("Job $id not found.");
            return "Job $id not found.";
        }
        if ($job->status != self::JOB_STATUS_RUNNING) {
            $GLOBALS['log']->fatal("Job $id is not marked as running.");
            return "Job $id is not marked as running.";
        }
        if ($job->client != $client) {
            $GLOBALS['log']->fatal("Job $id belongs to client {$job->client}, can not run as $client.");
            return "Job $id belongs to another client, can not run as $client.";
        }
        $job->job_done = false;
        register_shutdown_function([$job, 'unexpectedExit']);
        $res = $job->runJob();
        $job->job_done = true;
        return $res;
    }

    /**
     * Error handler, assembles the error messages
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
            case E_USER_WARNING:
            case E_COMPILE_WARNING:
            case E_CORE_WARNING:
            case E_WARNING:
                $type = 'Warning';
                break;
            case E_USER_ERROR:
            case E_COMPILE_ERROR:
            case E_CORE_ERROR:
            case E_ERROR:
                $type = 'Fatal Error';
                break;
            case E_PARSE:
                $type = 'Parse Error';
                break;
            case E_RECOVERABLE_ERROR:
                $type = 'Recoverable Error';
                break;
            default:
                // Ignore errors we don't know about
                return;
        }
        $errstr = strip_tags($errstr);
        $this->errors .= sprintf(translate('ERR_PHP', 'SchedulersJobs'), $type, $errno, $errstr, $errfile, $errline) . "\n";
    }

    /**
     * Change current user to given user
     * @param User $user
     */
    protected function sudo(User $user)
    {
        $GLOBALS['current_user'] = $user;
        // Reset the session
        if (!headers_sent()) {
            //Hack for php 5.3 where session_status is not availible
            if (!@session_start()) {
                session_destroy();
                session_start();
            }
            session_regenerate_id();
        }
        $_SESSION['is_valid_session'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['type'] = 'user';
        $_SESSION['authenticated_user_id'] = $user->id;
    }

    /**
     * Set environment to the user of this job
     * @return boolean
     */
    protected function setJobUser()
    {
        // set up the current user and drop session
        if (!empty($this->assigned_user_id)) {
            $this->old_user = $GLOBALS['current_user'];
            if (empty($this->user->id) || $this->assigned_user_id != $this->user->id) {
                $this->user = BeanFactory::getBean('Users', $this->assigned_user_id);
                if (empty($this->user->id)) {
                    $this->resolveJob(self::JOB_FAILURE, sprintf(translate('ERR_NOSUCHUSER', 'SchedulersJobs'), $this->assigned_user_id));
                    return false;
                }
            }
            $this->sudo($this->user);
        } else {
            $this->resolveJob(self::JOB_FAILURE, translate('ERR_NOUSER', 'SchedulersJobs'));
            return false;
        }
        return true;
    }

    /**
     * Restore previous user environment
     */
    protected function restoreJobUser()
    {
        if (!empty($this->old_user->id) && $this->old_user->id != $this->user->id) {
            $this->sudo($this->old_user);
        }
    }

    private function run(callable $func, array $params)
    {
        $bean = BeanFactory::newBean('Schedulers');
        $bean->id = $this->scheduler_id;

        // Create the Cronjob subject and activate it
        $subject = new CronJob($bean);
        $context = Container::getInstance()->get(Context::class);
        $context->activateSubject($subject);

        try {
            return call_user_func_array($func, $params);
        } finally {
            $context->deactivateSubject($subject);
        }
    }

    /**
     * Run this job
     * @return bool Was the job successful?
     */
    public function runJob()
    {
        require_once 'modules/Schedulers/_AddJobsHere.php';

        $this->errors = '';
        $exJob = explode('::', $this->target, 2);
        if ($exJob[0] == 'function') {
            // set up the current user and drop session
            if (!$this->setJobUser()) {
                return false;
            }
            $func = $exJob[1];
            $GLOBALS['log']->debug("----->SchedulersJob calling function: $func");
            set_error_handler([$this, 'errorHandler'], E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
            if (!is_callable($func)) {
                $this->resolveJob(self::JOB_FAILURE, sprintf(translate('ERR_CALL', 'SchedulersJobs'), $func));
                return false;
            }
            $data = [$this];
            if (!empty($this->data)) {
                $data[] = $this->data;
            }
            $res = $this->run($func, $data);
            restore_error_handler();
            $this->restoreJobUser();
            if ($this->status == self::JOB_STATUS_RUNNING) {
                // nobody updated the status yet - job function could do that
                if ($res) {
                    $this->resolveJob(self::JOB_SUCCESS);
                    return true;
                } else {
                    $this->resolveJob(self::JOB_FAILURE);
                    return false;
                }
            } else {
                return $this->resolution != self::JOB_FAILURE;
            }
        } elseif ($exJob[0] == 'url') {
            if (function_exists('curl_init')) {
                $GLOBALS['log']->debug('----->SchedulersJob firing URL job: ' . $exJob[1]);
                set_error_handler([$this, 'errorHandler'], E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
                if ($this->fireUrl($exJob[1])) {
                    restore_error_handler();
                    $this->resolveJob(self::JOB_SUCCESS);
                    return true;
                } else {
                    restore_error_handler();
                    $this->resolveJob(self::JOB_FAILURE);
                    return false;
                }
            } else {
                $this->resolveJob(self::JOB_FAILURE, translate('ERR_CURL', 'SchedulersJobs'));
            }
        } elseif ($exJob[0] == 'class') {
            $container = Container::getInstance();
            $class = $exJob[1];

            if ($container->has($class)) {
                $tmpJob = $container->get($class);
            } else {
                $tmpJob = new $class();
            }

            if ($tmpJob instanceof RunnableSchedulerJob) {
                // set up the current user and drop session
                if (!$this->setJobUser()) {
                    return false;
                }
                $tmpJob->setJob($this);
                set_error_handler([$this, 'errorHandler'], E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
                $res = $this->run([$tmpJob, 'run'], [$this->data]);
                restore_error_handler();
                $this->restoreJobUser();
                if ($this->status == self::JOB_STATUS_RUNNING) {
                    // nobody updated the status yet - job class could do that
                    if ($res) {
                        $this->resolveJob(self::JOB_SUCCESS);
                        return true;
                    } else {
                        $this->resolveJob(self::JOB_FAILURE);
                        return false;
                    }
                } else {
                    return $this->resolution != self::JOB_FAILURE;
                }
            } else {
                $this->resolveJob(self::JOB_FAILURE, sprintf(translate('ERR_JOBTYPE', 'SchedulersJobs'), strip_tags($this->target)));
            }
        } else {
            $this->resolveJob(self::JOB_FAILURE, sprintf(translate('ERR_JOBTYPE', 'SchedulersJobs'), strip_tags($this->target)));
        }
        return false;
    }
}  // end class Job

/**
 * Runnable job queue job
 *
 */
interface RunnableSchedulerJob
{
    /**
     * @abstract
     * @param SchedulersJob $job
     */
    public function setJob(SchedulersJob $job);

    /**
     * @abstract
     *
     */
    public function run($data);
}
