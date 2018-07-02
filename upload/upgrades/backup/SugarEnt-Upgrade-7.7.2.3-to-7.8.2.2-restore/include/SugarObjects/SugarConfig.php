<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
 * Config manager
 * @api
 */
class SugarConfig
{
    public $_cached_values = array();

    static function getInstance() {
        static $instance = null;
        if (is_null($instance)) {
            $instance = new SugarConfig();
        }
        return $instance;
    }

    function get($key, $default = null) {
        if (!isset($this->_cached_values[$key])) {
            $this->_cached_values[$key] = isset($GLOBALS['sugar_config']) ?
                SugarArray::staticGet($GLOBALS['sugar_config'], $key, $default) :
                $default;
        }
        return $this->_cached_values[$key];
    }

    function clearCache($key = null) {
        if (is_null($key)) {
            $this->_cached_values = array();
        } else {
            unset($this->_cached_values[$key]);
        }
    }
}

