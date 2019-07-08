<?php

/**
 * The file used to handle listview related module labels 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class retrieve_module_label_class {

    function retrieve_module_label($bean, $event, $arguments) {
        global $app_list_strings,$db;

        // retrieve Recipient Module name Label
        if (!empty($bean->parent_type)) {
            $bean->parent_type = $app_list_strings['moduleList'][$bean->parent_type];
        }
        // retrieve Target Module name Label
        if (!empty($bean->target_parent_type)) {
            
            $qry = "SELECT target_parent_id FROM bc_survey_submission WHERE id = '{$bean->id}' ";
            $result = $db->query($qry);
            
            $id = $db->fetchByAssoc($result);

            $orelated_bean = BeanFactory::getBean($bean->target_parent_type, $id['target_parent_id']);
            
            if (!empty($orelated_bean->id)) {
                $bean->assigned_user_id = $orelated_bean->assigned_user_id;
                $bean->team_set_id = $orelated_bean->team_set_id;
                $bean->team_id = $orelated_bean->team_id;
                $bean->acl_team_set_id = $orelated_bean->acl_team_set_id;
            }
            
            $bean->target_parent_type = $app_list_strings['moduleList'][$bean->target_parent_type];
        }
    }

}

?>
