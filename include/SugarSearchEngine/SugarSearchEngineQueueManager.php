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
 * Queueing class for after_save hooks
 * @api
 */
class SugarSearchEngineQueueManager
{

    /**
     * @param $bean
     * @param $event
     * @param $args
     */
    function populateIndexQueue($bean, $event, $args)
    {
        $GLOBALS['log']->info("Adding the following bean to the populate queue- module: {$bean->object_name} , id: {$bean->id}");
        require_once('include/SugarSearchEngine/SugarSearchEngineFactory.php');
        $searchEngine = SugarSearchEngineFactory::getInstance();
        /**
         * Due to the inability to update a documents fields when the field type is array
         * we need to reindex the entire bean.
         */
        if($bean instanceof SugarFavorites) {
            $new_bean = BeanFactory::getBean($bean->module, $bean->record_id);
            $searchEngine->indexBean($new_bean, FALSE);
        }
        else {
            $searchEngine->indexBean($bean, FALSE);
        }
    }
}