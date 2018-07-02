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
/**
 * Session handler for Sugar
 */
class SugarSessionHandler extends SessionHandler
{
    /**
     * Session start time
     */
    protected $session_start = null;

    /**
     * Total session time
     */
    protected $session_time = null;

    /**
     * Maximum session time
     */
    protected $max_session_time = null;

    /**
     * Log management
     * @var LoggerManager
     */
    protected $log;

    public function __construct()
    {
        $this->max_session_time = SugarConfig::getInstance()->get('max_session_time');
        $this->log = LoggerManager::getLogger('SugarCRM');
    }

    public function open($save_path, $session_id)
    {
        parent::open($save_path, $session_id);
        $this->session_start = time();
    }

    public function close()
    {
        parent::close();
                
        if ($this->isCurrentSessionExceeded()) {
            $this->log->error(sprintf("[SessionLock] Session lock was held for %s seconds which is longer than the maximum of %s seconds. Request details: 
                SERVER_NAME     | %s 
                SERVER_ADDR     | %s 
                SCRIPT_FILENAME | %s 
                REQUEST_METHOD  | %s 
                SCRIPT_NAME     | %s 
                REQUEST_URI     | %s 
                QUERY_STRING    | %s ",
                $this->session_time,
                $this->max_session_time,
                $_SERVER['SERVER_NAME'],
                $_SERVER['SERVER_ADDR'],
                $_SERVER['SCRIPT_FILENAME'],
                $_SERVER['REQUEST_METHOD'],
                $_SERVER['SCRIPT_NAME'],
                $_SERVER['REQUEST_URI'],
                $_SERVER['QUERY_STRING']
            ));           
        }
    }

    /**
     * Calculate session time
     * @return int
     */
    public function getCurrentSessionTime()
    {
        if (!$this->session_start) {
            return false;
        }

        return time() - $this->session_start;
    }

    /**
     * Check if session time more than defined treshhold
     * @return bool
     */
    public function isCurrentSessionExceeded() 
    {
        $this->session_time = $this->getCurrentSessionTime();

        if ($this->max_session_time && $this->session_time) {
            return $this->session_time > $this->max_session_time;
        }
        
        return false;
    }
}
