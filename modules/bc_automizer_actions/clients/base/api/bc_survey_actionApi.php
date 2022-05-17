<?php

/**
 * The file used to set custom api related to survey automizer actions
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

require_once 'clients/base/api/ModuleApi.php';
require_once 'data/BeanFactory.php';

class bc_survey_actionApi extends ModuleApi {

    public function registerApiRest() {
        return array(
            'getRecModules' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_actions', 'getRecModules'),
                'pathVars' => array('', ''),
                'method' => 'getRecModules',
                'shortHelp' => 'get recipient modules as per selection of recipient type',
                'longHelp' => '',
            ),
            'getSurveyList' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_actions', 'getSurveyList'),
                'pathVars' => array('', ''),
                'method' => 'getSurveyList',
                'shortHelp' => 'get all survey',
                'longHelp' => '',
            ),
            'DisplayActionList' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_actions', 'DisplayActionList'),
                'pathVars' => array('', ''),
                'method' => 'DisplayActionList',
                'shortHelp' => 'List of actions',
                'longHelp' => '',
            ),
            'saveActions' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey_actions', 'saveActions'),
                'pathVars' => array('', ''),
                'method' => 'saveActions',
                'shortHelp' => 'save actions aplied to current automizer',
                'longHelp' => '',
            ),
            'removeAction' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_actions', 'removeAction'),
                'pathVars' => array('', ''),
                'method' => 'removeAction',
                'shortHelp' => 'Removes survey automizer condition and remove its relationship',
                'longHelp' => '',
            ),
            'getActionRecord' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_actions', 'getActionRecord'),
                'pathVars' => array('', ''),
                'method' => 'getActionRecord',
                'shortHelp' => 'Get action record from given action id',
                'longHelp' => '',
            ),
        );
    }

    /**
     * Function : getRecModules
     *    get recipient modules as per selection of recipient type
     * 
     * @return array - module_list
     */
    public function getRecModules($api, $args) {
        global $mod_strings, $app_list_strings;
        require_once 'data/SugarBean.php';
        $record = $args['record_id'];
        $oAutomizer = new bc_survey_automizer();
        $oAutomizer->retrieve($record);
        //get target module
        $dom_name = $oAutomizer->target_module;

        //get recipient type
        $rec_type = $args['rec_type'];
        if ($rec_type == 'related_module') {
            $result_array = array();

            $allowed_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects');
            $dom_Obj = BeanFactory::getBean($dom_name);
            $rel_field = $dom_Obj->field_defs;
            foreach ($rel_field as $k => $field) {
                // get linked fields related module
                if ($field['type'] == 'link') {
                    $rel_mod_name = ($field['name']);
                    $dom_Obj->load_relationship($rel_mod_name);

                    //Get Related module name from given relationship name
                    if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && $dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'] == 'many-to-many') {
                        $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
                    } if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && !empty($dom_Obj->$rel_mod_name->relationship->def['relationship_type']) && $dom_Obj->$rel_mod_name->relationship->def['relationship_type'] == 'one-to-many' && empty($field['link_type']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] == $dom_Obj->$rel_mod_name->relationship->def['rhs_module']) {
                        $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
                    } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $dom_name && $dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'] == 'many-to-many') {
                        $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
                    } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $dom_name && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && $dom_Obj->$rel_mod_name->relationship->def['relationship_type'] == 'many-to-many') {
                        $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
                    } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module']) && !empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && $dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'] == 'many-to-many') {
                        $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
                    } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module']) && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && !empty($dom_Obj->$rel_mod_name->relationship->def['relationship_type']) && $dom_Obj->$rel_mod_name->relationship->def['relationship_type'] == 'many-to-many') {
                        $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
                    } else if (!empty($rel_mod_name)) {
                        $rel_mod_name = ucfirst($rel_mod_name);
                    }

                    if (in_array($rel_mod_name, $allowed_modules)) {
                        $result_array[$field['name']] = $app_list_strings['moduleList'][$rel_mod_name] . ' ( ' . $field['name'] . ' )';
                        $result_array[0] = 'Select Module';
                    }
                }
            }
            asort($result_array);
        } else if ($rec_type == 'target_module') {
            $result_array = array();

            $allowed_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects');

            $dom_Obj = BeanFactory::getBean($dom_name);
            $rel_field = $dom_Obj->field_defs;
            $exclude_field = array();
            foreach ($rel_field as $k => $field) {
                // commented to remove link fields from target module list though its already comes with relate field

                if ($field['type'] == 'parent') {
                    // get label from module language file
                    $lang = return_module_language('en_us', $dom_name);
                    $result_array[$field['name']] = !empty($lang[$field['vname']]) ? $lang[$field['vname']] : $field['name'];
                }
                if ($field['type'] == 'relate' && $field['rname'] != 'id') {
                    // get label from module language file
                    $lang = return_module_language('en_us', $dom_name);

                    $rel_mod_name = ($field['name']);
                    $dom_Obj->load_relationship($rel_mod_name);

                    if (empty($field['link']) && in_array($field['module'], $allowed_modules)) {
                        $label = trim($lang[$field['vname']], ':');
                        if (!empty($label)) {
                            $result_array[$field['name']] = !empty($label) ? $label : $field['name'];
                        } else {
                            $result_array[$field['name']] = !empty($label) ? $label : $field['name'];
                        }
                    }

                    if (!empty($field['link']) && $field['source'] == 'non-db' && in_array($field['module'], $allowed_modules) && !in_array($field['name'], $exclude_field)) {
                        $exclude_field[] = $field['id_name'];
                        $label = trim($lang[$field['vname']], ':');
                        if (!empty($label)) {
                            $result_array[$field['name']] = !empty($label) ? $label : $field['name'];
                        } else {
                            $result_array[$field['name']] = !empty($label) ? $label : $field['name'];
                        }
                    }
                }
            }
        }




        return $result_array;
    }

    function getSurveyList($api, $args) {
        // get automizer
        $automizer_id = $args['automizer_id'];
        $oAutomizer = BeanFactory::getBean('bc_survey_automizer', $automizer_id);
        $action_id = (!empty($args['action_id'])) ? $args['action_id'] : '';
        // retrieve related action survey
        $actions = $oAutomizer->get_linked_beans('bc_survey_automizer_bc_automizer_actions', 'bc_automizer_actions');
        $excludeSurveyList = array();
        foreach ($actions as $oAction) {
            if (!empty($action_id) && $action_id != $oAction->id) {
                array_push($excludeSurveyList, $oAction->survey_id);
            } else if (empty($action_id)) {
                array_push($excludeSurveyList, $oAction->survey_id);
            }
        }

        $todayDBFormat = date("Y-m-d h:i:s");

        require_once('include/SugarQuery/SugarQuery.php');
        $query = new SugarQuery();

        $query->select(array('id', 'name', 'enable_data_piping','survey_status' ));

        $query->from(BeanFactory::getBean('bc_survey'));

        $query->where()->queryOr()->equals("enable_data_piping", 0);
        // Survey Status :: LoadedTech Customization
        $query->where()->equals("survey_status", "Active");
        // Survey Status :: LoadedTech Customization END

//        $query->Where()->queryOr()->isNull('end_date')->gte('end_date', $todayDBFormat);
//        $query->Where()->queryOr()->isNull('start_date')->lte('start_date', $todayDBFormat);

        $query->orderBy('name', 'ASC');

        $results = $query->execute();

        $list = array();
        foreach ($results as $row) {
            if (!in_array($row['id'], $excludeSurveyList)) {
                $list[$row['id']] = $row['name'];
            }
        }

        return $list;
    }

    /**
     * Function : saveActions
     *    save actions aplied to current automizer
     * 
     * @return string - action id
     */
    public function saveActions($api, $args) {
        //survey automizer record id
        $record_id = $args['record_id'];
        $action_id = $args['action_id'];

        //retrieve current record actions count

        $oAutomizer = new bc_survey_automizer();
        $oAutomizer->retrieve($record_id);
        $targetModule = $oAutomizer->target_module;
        if (empty($action_id)) {
            $oAutomizer->load_relationship('bc_survey_automizer_bc_automizer_actions');
            $action_orders = array();
            $count = 0;
            foreach ($oAutomizer->bc_survey_automizer_bc_automizer_actions->getBeans() as $act) {
                array_push($action_orders, $act->action_order);
            }

            if (!empty($action_orders)) {
                $count = max($action_orders);
            }
            $count++;
        }

        $rec_type = $args['rec_type'];
        $rec_module = $args['rec_module'] != 'Select Module' ? $args['rec_module'] : '';
        $filter_by = $args['filter_by'];
        $rec_field = $args['rec_field'];
        $compare_value = $args['value'];
        $rec_operator = $args['operator'];
        $email_field = $args['email_field'];
        $surveyid = $args['surveyid'] != '0' ? $args['surveyid'] : '';
        $email_temp_id = $args['email_temp_id'];

        $oAutoAction = new bc_automizer_actions();
        if (!empty($action_id)) {
            $oAutoAction->retrieve($action_id);
        }
        $oAutoAction->recipient_type = $rec_type;
        $oAutoAction->recipient_module = $rec_module;
        $oAutoAction->filter_by = $filter_by;
        $oAutoAction->recipient_field = $rec_field;
        $oAutoAction->recipient_operator = $rec_operator;
        $oAutoAction->compare_value = $compare_value;
        $oAutoAction->recipient_email_field = $email_field;
        $oAutoAction->survey_id = $surveyid;
        $oAutoAction->email_template_id = $email_temp_id;
        if (empty($action_id)) {
            $oAutoAction->action_order = $count;
        }

        $oAutoAction->save();

        //Relate Actions with Survey Automizer
        $oAutoAction->load_relationship('bc_survey_automizer_bc_automizer_actions');
        $oAutoAction->bc_survey_automizer_bc_automizer_actions->add($record_id);


        return $oAutoAction->id;
    }

    function DisplayActionList($api, $args) {
        global $app_list_strings;
        $record_id = $args['record'];

        // Retrive Survey Automizer Target Module And Related Survey Automizer Conditions
        $oSurveyAutomizer = new bc_survey_automizer();
        $oSurveyAutomizer->retrieve($record_id);
        $targetModule = $oSurveyAutomizer->target_module;
        $oSurveyAutomizer->load_relationship('bc_survey_automizer_bc_automizer_actions');
        $count = 0;
        $list = array();
        foreach ($oSurveyAutomizer->bc_survey_automizer_bc_automizer_actions->getBeans() as $act) {
            //list of actions
            $oSurvey = new bc_survey();
            $oSurvey->retrieve($act->survey_id);
            $lang = return_module_language('en_us', $targetModule);
            $dom_Obj = BeanFactory::getBean($targetModule);
            $rel_field = $dom_Obj->field_defs;
            $recipient_field = null;
            if ($act->recipient_type == 'target_module') {
                foreach ($rel_field as $k => $field) {
                    if ($field['name'] == $act->recipient_module) {
                        $field_label = trim($lang[$field['vname']], ':');
                        if (!empty($field_label)) {
                            $label = trim($lang[$field['vname']], ':');
                        } else {
                            $label = ucfirst($act->recipient_module);
                        }
                        $targetModuleLabel = !empty($app_list_strings['moduleList'][$targetModule]) ? $app_list_strings['moduleList'][$targetModule] : $targetModule ;
                        $recipient_field = $targetModuleLabel . ' ( ' . $label . ' )';
                    }
                }
            } else {
                foreach ($rel_field as $k => $field) {
                    if ($field['name'] == $act->recipient_module) {
                        $dom_Obj->load_relationship($act->recipient_module);

                        $rel_mod_name = $act->recipient_module;
                        //Get Related module name from given relationship name
                        if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && $dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'] == 'one-to-many') {

                            $recipient_field = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
                        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $targetModule) {
                            $recipient_field = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
                        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module'])) {
                            $recipient_field = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
                        } else if (empty($rel_mod_name)) {
                            $recipient_field = ucfirst($rel_mod_name);
                        }
                    }
                }
            }
            $SurveyTitle = $oSurvey->name;
            $rec_module = !empty($recipient_field) ? $recipient_field : $act->recipient_module;

            // check email template exists or not
            $survey_id = $act->survey_id;
            require_once 'custom/include/utilsfunction.php';
            $emailTemplate = '0';
            $emailTempID = getEmailTemplateBySurveyID($survey_id);
            if ($emailTempID) {
                $emailTemplate = '1';
            }

            $list[$act->action_order] = array(
                'id' => $act->id,
                'rec_type' => $app_list_strings['recipient_type'][$act->recipient_type],
                'rec_module' => $rec_module,
                'email_field' => $app_list_strings['email_field'][$act->recipient_email_field],
                'survey' => '<a style="font-size:12px; color:#176de5; font-family: Helvetica, Arial, sans-serif;" href="#bc_survey/' . $act->survey_id . '">' . $SurveyTitle . '</a>',
                'emailtemplate' => $emailTemplate,
                'action_order' => $act->action_order
            );
            $count++;
        }

        return $list;
    }

    function removeAction($api, $args) {
        $record_id = $args['record'];
        $parent_id = $args['parent_id'];

        $oAction = new bc_automizer_actions();
        $oAction->retrieve($record_id);

        //remove relatioships
        $oAction->load_relationship('bc_survey_automizer_bc_automizer_actions');
        $oAction->bc_survey_automizer_bc_automizer_actions->delete($oAction->id, $parent_id);

        $oAction->deleted = 1;
        $oAction->save();

        if ($oAction->save()) {
            return true;
        }
    }

    function getActionRecord($api, $args) {
       
        $action_id = $args['action_id'];

        $result = array();

        $oSurveyAutomizerAction = new bc_automizer_actions();
        $oSurveyAutomizerAction->retrieve($action_id);
        $rec_type = $oSurveyAutomizerAction->recipient_type;
        $rec_module = $oSurveyAutomizerAction->recipient_module;
        $filter_by = $oSurveyAutomizerAction->filter_by;
        $rec_field = $oSurveyAutomizerAction->recipient_field;
        $operator = $oSurveyAutomizerAction->recipient_operator;
        $value = $oSurveyAutomizerAction->compare_value;
        $email_field = $oSurveyAutomizerAction->recipient_email_field;
        $survey_id = $oSurveyAutomizerAction->survey_id;

        //details of actions

        $result = array(
            'rec_type' => $rec_type,
            'rec_module' => $rec_module,
            'filter_by' => $filter_by,
            'rec_field' => $rec_field,
            'operator' => $operator,
            'value' => $value,
            'email_field' => $email_field,
            'survey' => $survey_id,
        );

        return $result;
    }

}
