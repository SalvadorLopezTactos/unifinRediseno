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

require_once("include/SugarSearchEngine/Interface.php");

/**
 * Abstract class to represent a result entry.
 * @api
 */
abstract class SugarSearchEngineAbstractResult implements SugarSearchEngineResult
{

    /**
     * @var SugarBean
     */
    protected $bean;

    public function getModuleName()
    {
        $moduleName = $this->getModule();
        if( isset($GLOBALS['app_list_strings']['moduleList'][$moduleName]) )
            return $GLOBALS['app_list_strings']['moduleList'][$moduleName];
        else
            return $moduleName;
    }

    public function getSummaryText()
    {
        if($this->bean !== FALSE)
            return $this->bean->get_summary_text();
    }

    public function __toString()
    {
        return __CLASS__ . " " . $this->getModule() . ": " . $this->getSummaryText() . " " . $this->getId();
    }


    /**
     *
     * @return integer
     */
    public function getScore()
    {
        return 0;
    }

}


