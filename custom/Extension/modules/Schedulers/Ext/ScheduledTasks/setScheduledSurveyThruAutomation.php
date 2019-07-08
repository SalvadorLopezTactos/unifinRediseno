<?php

/**
 * The file used to set schedular job for sending survey 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
$job_strings[] = 'setScheduledSurveysThruAutomation';

/**
 * Used to send survey after matching all conditions
 *
 * @return     bool TRUE - survey is send
 */
function setScheduledSurveysThruAutomation() {

    $isNew = false;

    require_once('include/SugarQuery/SugarQuery.php');

    // get list of modules that we can run workflow against
    $query = new SugarQuery();
    $query->select(array('target_module'));
    $query->from(BeanFactory::getBean('bc_survey_automizer'));
    $query->where()->equals('status', 'active');
    $query->groupBy('target_module');
    $results = $query->execute();

    // flatten array
    $allowed_modules = array();
    foreach ($results as $r) {
        $allowed_modules[] = $r['target_module'];
    }
    $GLOBALS['log']->fatal('This is the allowed modules : --- ', print_r($allowed_modules, 1));
    // traverse all modules and its all records to find matching conditions
    foreach ($allowed_modules as $key => $module) {
        $query = new SugarQuery();

        $query->select(array('id'));

        $query->from(BeanFactory::getBean('bc_survey_automizer'));

        $query->where()->equals('execution_occurs', 'when_survey_scheduler_executes');
        $query->where()->equals('target_module', $module);
        $query->where()->equals('status', 'active');

        $results = $query->execute();
        $GLOBALS['log']->fatal('This is the all automation of current module ' . $module . ' : --- ', print_r($results, 1));
        //list applicable survey automizer 
        $listApplicableAutomizer = array();

        foreach ($results as $row) {
            $listApplicableAutomizer[] = $row['id'];
        }
        $GLOBALS['log']->fatal("This is the list of applicable automizer : " . print_r($listApplicableAutomizer, 1));


        // traverse all modules and its all records to find matching conditions
        foreach ($listApplicableAutomizer as $k => $automizerId) {

            $query = new SugarQuery();

            $query->select(array('id'));

            $query->from(BeanFactory::getBean($module));

            $query->where()->equals('deleted', '0');

            $results_all_records = $query->execute();
            $GLOBALS['log']->fatal('This is the all records of current module ' . $module . ' : --- ', print_r($results_all_records, 1));

            // For every Automizer check conditions
            foreach ($results_all_records as $k => $moduleId) {
                $bean = BeanFactory::getBean($module, $moduleId['id']);
                $result = array();
                $oAutomizer = new bc_survey_automizer();
                $oAutomizer->retrieve($automizerId);
                $execution_type = $oAutomizer->execution_occurs;

                // Survey Status :: LoadedTech Customization
                // Go through all action survey to check Active or not
                $oAutomizer->load_relationship('bc_survey_automizer_bc_automizer_actions');
                foreach ($oAutomizer->bc_survey_automizer_bc_automizer_actions->getBeans() as $act) {
                    $oSurvey = BeanFactory::getBean('bc_survey', $act->survey_id);
                    // check if survey is active or not
                    if ($oSurvey->survey_status == 'Active') {
                        $result_flag = check_valid_survey_automizer_conditions($automizerId, $isNew, $bean);
                        $result[] = $result_flag;

                        $GLOBALS['log']->fatal("This is the condition result o automizer  $automizerId : " . print_r($result, 1));
                        if ($result != NULL && !in_array(false, $result)) {
                            $GLOBALS['log']->fatal("This is the no false : " . print_r('', 1));
                            send_survey_from_automizer_action($automizerId, $bean, $execution_type);
                        }
                    } else {
                        $GLOBALS['log']->debug("BeforeSaveLogicHook : This survey is deactivated :  $oSurvey->name");
                    }
                }
            }
        }
    }
}

/*
 * this function is used for checking conditions for given modules are met or not
 * 
 * @params
 * $automizerId - automizer id
 * $isNew - is new record saving or updating flag
 * $bean - current bean
 */

function check_valid_survey_automizer_conditions($automizerId, $isNew, $bean) {
    $result = false;
    $result_array = array();
    $result_array_related = array();
    $oAutomizer = new bc_survey_automizer();
    $oAutomizer->retrieve($automizerId);
    $execution_type = $oAutomizer->execution_occurs;
    $applied_to = $oAutomizer->applied_to;
    $isApplicable = false;
    //Check Applicable Fpr Automizer on basis of applied to field for new and update record
    if ($applied_to == 'new_and_updated_records') {
        $isApplicable = true;
    }
    //new record
    else if ($applied_to == 'new_records_only' && $isNew) {
        $isApplicable = true;
    }
    // update record
    else if ($applied_to == 'updated_records_only' && !$isNew) {
        $isApplicable = true;
    }
    // not applicable
    else {
        $GLOBALS['log']->fatal("This is not applicable to send survey from automizer");
    }
    if ($isApplicable) {

        // Get Related Survey Automizer Conditions
        $oAutomizer->load_relationship('bc_automizer_condition_bc_survey_automizer');
        $conditionList = array();
        foreach ($oAutomizer->bc_automizer_condition_bc_survey_automizer->getBeans() as $con) {
            $conditionList[$con->condition_order] = $con;
        }
        // For every Condition return result flag
        foreach ($conditionList as $key => $condition) {
            $conditionRelatedModule = '';
            $GLOBALS['log']->fatal("This is the condition condition->condition_module : " . print_r($condition->condition_module, 1));
            $rel_module_array = explode(':', $condition->condition_module);
            $GLOBALS['log']->fatal("This is the condition rel_module_array : " . print_r($rel_module_array, 1));
            if (!empty($rel_module_array)) {
                if (empty($rel_module_array[1])) {
                    $isRelatedModuleCondition = false;
                    $conditionTargetModule = $rel_module_array[0];
                } else {
                    $isRelatedModuleCondition = true;
                    $conditionRelatedModule = trim($rel_module_array[1]);
                }
            } else {
                $isRelatedModuleCondition = false;
                $conditionTargetModule = $condition->condition_module;
            }
            $GLOBALS['log']->fatal("This is the condition related module : " . print_r($conditionRelatedModule, 1));
            // Check all conditions for Target Module
            if (!$isRelatedModuleCondition && !empty($conditionTargetModule)) {
                $result_flag = checkTargetModuleConditions($condition, $automizerId, $bean, $execution_type);
                $result_array[] = $result_flag;
            }
            // Check all conditions for Related Module
            if ($isRelatedModuleCondition && !empty($conditionRelatedModule)) {

                foreach ($bean->field_defs as $k => $field) {
                    // $GLOBALS['log']->fatal("This is the field : " . print_r($field['module'], 1));
                    if ($field['module'] == ucfirst($conditionRelatedModule)) {
                        if (empty($field['link'])) {
                            $relationship_name = $field['name'];
                        } else {
                            $relationship_name = $field['link'];
                        }
                        break;
                    }
                    // get linked fields related module
                    if ($field['type'] == 'link') {
                        if ($field['name'] == ($conditionRelatedModule)) {
                            $relationship_name = $field['name'];
                            break;
                        }
                    }
                }
                $GLOBALS['log']->fatal("This is the relationship name : " . print_r($relationship_name, 1));
                //Retrieve related bean object
                $bean->load_relationship($relationship_name);
                if ($bean->load_relationship($relationship_name)) {
                    $getRelatedBean = $bean->$relationship_name->getBeans();

                    if ($getRelatedBean) {

                        foreach ($getRelatedBean as $relatedClass) {
                            $GLOBALS['log']->fatal("This is the related bean record for condition checking : " . print_r($relatedClass->id, 1));
                            //get condition status
                            $result_flag = checkTargetModuleConditions($condition, $automizerId, $relatedClass, $execution_type);
                            // if condition satisfaction filter type is any related then match condition for any one record
                            if ($condition->filter_by == 'any_related' && $result_flag) {
                                $reassign_array = array($result_flag);
                                $result_array_related_true = array();
                                $result_array_related_true = $reassign_array;
                                $result_array_related[] = $result_flag;
                                $GLOBALS['log']->fatal("This is the result any related true : " . print_r($result_array_related_true, 1));
                                break;
                            } else {
                                $result_array_related[] = $result_flag;
                                $GLOBALS['log']->fatal("This is the result any related false 1 : " . print_r($result_array_related, 1));
                            }
                        }
                    }
                    // If no any related record
                    else {
                        $GLOBALS['log']->fatal("This is the relationship bean is null 1: " . print_r($getRelatedBean, 1));
                        $reassign_array = array(false);
                        $result_array_related = array();
                        $result_array_related = $reassign_array;
                        $GLOBALS['log']->fatal("This is the result any related false 2 : " . print_r($result_array_related, 1));
                        break;
                    }
                }
                // if no any relationship found for given relationship name
                else {
                    $GLOBALS['log']->fatal("This is the relationship bean is null 2: " . print_r($getRelatedBean, 1));
                    $reassign_array = array(false);
                    $result_array_related = array();
                    $result_array_related = $reassign_array;
                    $GLOBALS['log']->fatal("This is the result any related false 3 : " . print_r($result_array_related, 1));
                    break;
                }
                $GLOBALS['log']->fatal("This is the related bean : $conditionRelatedModule : - Relationship name : " . print_r($relationship_name, 1));
            }
        }
    }
    if ($condition->filter_by == 'all_related' && in_array(false, $result_array_related)) {
        $result_array_related = array(false);
    } else if ($condition->filter_by == 'any_related' && in_array(true, $result_array_related)) {
        $result_array_related = array(true);
    }
    $GLOBALS['log']->fatal("This is the result array related -------------------------: " . print_r($result_array_related, 1));
    $result_array = array_merge($result_array, $result_array_related);

    $GLOBALS['log']->fatal("This is the condition result in self function: " . print_r($result_array, 1));
    if ($result_array != NULL && !in_array(false, $result_array)) {
        $result = true;
    }
    return $result;
}

/*
 * this function is used for checking target module conditions for given modules are met or not
 * 
 * @params
 * $condition - condition bean
 * $automizerId - automizer id
 * $bean - bean current
 * $execution_type - execution type
 */

function checkTargetModuleConditions($condition, $automizerId, $bean, $execution_type) {

    $GLOBALS['log']->fatal('This is the checkTargetModuleConditions : ', print_r('', 1));

    $result = false;
    if ($condition->value_type == 'Value' || $condition->value_type == 'Date') {
        $result = checkValueType_value_or_field($condition, $automizerId, $bean, $condition->value_type, $execution_type);
    }
    // Check value for is null
    else if ($condition->condition_operator == 'is_null') {
        $field = $condition->condition_field;
        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($bean->$field . ' is....check for is empty', 1));
        if (empty($bean->$field)) {
            return true;
        }
    }
    // Check value for Any Change
    else if ($condition->condition_operator == 'Any_Change') {
        $condition_field = $condition->condition_field;
        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($bean->$condition_field . ' is....check for Any Change', 1));
        if (!empty($bean->fetched_row)) {
            foreach ($bean->fetched_row as $field => $value) {
                // compare current and previous saved field value
                if ($field == $condition_field) {
                    if ($bean->$condition_field != $value) {
                        return true;
                        break;
                    }
                }
            }
        }
        // bean fetch row not exists means record is new so true condition for any change
        else {
            return true;
        }
    }
    //check for value type is field
    else if ($condition->value_type == 'Field') {
        $result = checkValueType_value_or_field($condition, $automizerId, $bean, 'Field', $execution_type);
    }
    //check for value type is field
    else if ($condition->value_type == 'Multi') {
        $result = checkValueType_multi($condition, $automizerId, $bean, $execution_type);
    }
    return $result;
}

/*
 * this function is used for checking value or field conditions  for given modules are met or not
 * 
 * @params
 * $condition - condition bean
 * $automizerId - automizer id
 * $bean - bean current
 * $value_type - value type - value or field
 * $execution_type -  execution type
 */

function checkValueType_value_or_field($condition, $automizerId, $bean, $value_type, $execution_type) {

    //check compare bean is target module or not
    $oAutomizer = BeanFactory::getBean('bc_survey_automizer', $automizerId);
    $targetModule = $oAutomizer->target_module;

    $isTarget = false; // Checking Bean module is target module or not
    if ($targetModule == $bean->module_name) {
        $isTarget = true;
    }
    $result = false;
    //compare value and saving value
    $field = $condition->condition_field; //Condition Field
    $com_field = $condition->compare_value; // Comparing with Any Field Value
    //comparing value
    if ($value_type == 'Value') {
        $compare_value = $condition->compare_value;
    } else if ($value_type == 'Field') {
        $compare_value = $bean->$com_field;
    } else if ($value_type == 'Date') {
        /*
         * Check Field date matchs to Today's Date
         */
        if ($condition->compare_value == 'Today') {

            $timedate = new TimeDate();
            $compare_value = $timedate->nowDb();
            $bean_date = $bean->$field;
            // convert date to DB Format for comparing
            if ($field == 'date_entered' && empty($bean->$field)) {
                global $db;
                $qry = "SELECT date_entered FROM $bean->table_name WHERE id='" . $bean->id . "'";
                $resultQry = $db->query($qry);
                while ($row = $db->fetchByAssoc($resultQry)) {
                    $bean_date = $row['date_entered'];
                }
                // In case of New Record when Date Entered is not store anywhere
                if (empty($bean_date)) {
                    // Record is new or already created
                    $isNew = empty($bean->fetched_row) ? true : false;
                    if ($isNew == true) {
                        $bean_date = $compare_value;
                    }
                }
            } else {
                $beantimedate = $timedate->to_db($bean_date);
                if (!empty($beantimedate)) {
                    $bean_date = $timedate->to_db($bean_date);
                }
            }
            $tobe_compare_value = explode(' ', $bean_date)[0]; // bean field to be compared
            $compare_value = explode(' ', $compare_value)[0]; // compare value
        }
        /*
         * 
         * Check Field date matchs to Last week dates or not
         */ else if ($condition->compare_value == 'Last_Week') {

            $timedate = new TimeDate();
            $compare_value = $timedate->nowDb();
            $current_date = date('Y-m-d', strtotime($compare_value)); // Today
            $compare_value = date('Y-m-d', strtotime($compare_value . ' -7 day')); // Last 7 Days
            // convert date to DB Format for comparing
            $bean_date = $bean->$field;
            // convert date to DB Format for comparing
            if ($field == 'date_entered' && empty($bean->$field)) {
                global $db;
                $qry = "SELECT date_entered FROM $bean->table_name WHERE id='" . $bean->id . "'";
                $resultQry = $db->query($qry);
                while ($row = $db->fetchByAssoc($resultQry)) {
                    $bean_date = $row['date_entered'];
                }
                // In case of New Record when Date Entered is not store anywhere
                if (empty($bean_date)) {
                    // Record is new or already created
                    $isNew = empty($bean->fetched_row) ? true : false;
                    if ($isNew == true) {
                        $bean_date = $current_date;
                    }
                }
            } else {
                $beantimedate = $timedate->to_db($bean_date);
                if (!empty($beantimedate)) {
                    $bean_date = $timedate->to_db($bean_date);
                }
            }
            $tobe_compare_value = explode(' ', $bean_date)[0]; // bean field to be compared
            $compare_value = explode(' ', $compare_value)[0]; // compare value


            $compare_value_array = array();
            $period = new DatePeriod(
                    new DateTime($compare_value), new DateInterval('P1D'), new DateTime($current_date)
            );

            foreach ($period as $k => $value) {
                $compare_value_array[] = $value->format('Y-m-d');
            }

            $compare_value = $compare_value_array;
        }
        /*
         * Check Field date matchs to Last 30 Days dates or not
         */ else if ($condition->compare_value == 'Last_30_Days') {

            $timedate = new TimeDate();
            $compare_value = $timedate->nowDb();
            $current_date = date('Y-m-d', strtotime($compare_value)); // Today
            $compare_value = date('Y-m-d', strtotime($compare_value . ' -30 day')); // Last 30 Days
            // convert date to DB Format for comparing
            $bean_date = $bean->$field;
            // convert date to DB Format for comparing
            if ($field == 'date_entered' && empty($bean->$field)) {
                global $db;
                $qry = "SELECT date_entered FROM $bean->table_name WHERE id='" . $bean->id . "'";
                $resultQry = $db->query($qry);
                while ($row = $db->fetchByAssoc($resultQry)) {
                    $bean_date = $row['date_entered'];
                }
                // In case of New Record when Date Entered is not store anywhere
                if (empty($bean_date)) {
                    // Record is new or already created
                    $isNew = empty($bean->fetched_row) ? true : false;
                    if ($isNew == true) {
                        $bean_date = $current_date;
                    }
                }
            } else {
                $beantimedate = $timedate->to_db($bean_date);
                if (!empty($beantimedate)) {
                    $bean_date = $timedate->to_db($bean_date);
                }
            }
            $tobe_compare_value = explode(' ', $bean_date)[0]; // bean field to be compared
            $compare_value = explode(' ', $compare_value)[0]; // compare value


            $compare_value_array = array();
            $period = new DatePeriod(
                    new DateTime($compare_value), new DateInterval('P1D'), new DateTime($current_date)
            );

            foreach ($period as $k => $value) {
                $compare_value_array[] = $value->format('Y-m-d');
            }

            $compare_value = $compare_value_array;
        }
        /*
         * Check Field date matchs to Next 30 week dates or not
         */ else if ($condition->compare_value == 'Next_Week') {

            $timedate = new TimeDate();
            $compare_value = $timedate->nowDb();
            $current_date = date('Y-m-d', strtotime($compare_value)); // Today
            $compare_value = date('Y-m-d', strtotime($compare_value . ' +7 day')); // Next 7 Days
            // convert date to DB Format for comparing
            $bean_date = $bean->$field;
            // convert date to DB Format for comparing
            if ($field == 'date_entered' && empty($bean->$field)) {
                global $db;
                $qry = "SELECT date_entered FROM $bean->table_name WHERE id='" . $bean->id . "'";
                $resultQry = $db->query($qry);
                while ($row = $db->fetchByAssoc($resultQry)) {
                    $bean_date = $row['date_entered'];
                }
                // In case of New Record when Date Entered is not store anywhere
                if (empty($bean_date)) {
                    // Record is new or already created
                    $isNew = empty($bean->fetched_row) ? true : false;
                    if ($isNew == true) {
                        $bean_date = $current_date;
                    }
                }
            } else {
                $beantimedate = $timedate->to_db($bean_date);
                if (!empty($beantimedate)) {
                    $bean_date = $timedate->to_db($bean_date);
                }
            }
            $tobe_compare_value = explode(' ', $bean_date)[0]; // bean field to be compared
            $compare_value = explode(' ', $compare_value)[0]; // compare value


            $compare_value_array = array();
            $period = new DatePeriod(
                    new DateTime($current_date), new DateInterval('P1D'), new DateTime($compare_value)
            );

            foreach ($period as $k => $value) {
                $compare_value_array[] = $value->format('Y-m-d');
            }

            $compare_value = $compare_value_array;
        }
        /*
         * Check Field date matchs to Next 30 Days dates or not
         */ else if ($condition->compare_value == 'Next_30_Days') {

            $timedate = new TimeDate();
            $compare_value = $timedate->nowDb();
            $current_date = date('Y-m-d', strtotime($compare_value)); // Today
            $compare_value = date('Y-m-d', strtotime($compare_value . ' +30 day')); // Next 30 Days
            // convert date to DB Format for comparing
            $bean_date = $bean->$field;
            // convert date to DB Format for comparing
            if ($field == 'date_entered' && empty($bean->$field)) {
                global $db;
                $qry = "SELECT date_entered FROM $bean->table_name WHERE id='" . $bean->id . "'";
                $result = $db->query($qry);
                while ($row = $db->fetchByAssoc($result)) {
                    $bean_date = $row['date_entered'];
                }
                // In case of New Record when Date Entered is not store anywhere
                if (empty($bean_date)) {
                    // Record is new or already created
                    $isNew = empty($bean->fetched_row) ? true : false;
                    if ($isNew == true) {
                        $bean_date = $current_date;
                    }
                }
            } else {
                $beantimedate = $timedate->to_db($bean_date);
                if (!empty($beantimedate)) {
                    $bean_date = $timedate->to_db($bean_date);
                }
            }
            $tobe_compare_value = explode(' ', $bean_date)[0]; // bean field to be compared
            $compare_value = explode(' ', $compare_value)[0]; // compare value


            $compare_value_array = array();
            $period = new DatePeriod(
                    new DateTime($current_date), new DateInterval('P1D'), new DateTime($compare_value)
            );

            foreach ($period as $k => $value) {
                $compare_value_array[] = $value->format('Y-m-d');
            }

            $compare_value = $compare_value_array;
        }
    }

    // check value for bool type field
    if ($bean->field_defs[$field]['type'] == 'bool' && $compare_value == 'bool_true') {
        $compare_value = 1;
    } else if ($bean->field_defs[$field]['type'] == 'bool' && $compare_value == 'bool_false') {
        $compare_value = 0;
    }
    if (empty($tobe_compare_value)) {
        $tobe_compare_value = isset($bean->$field) ? $bean->$field : $bean->fetched_row[$field];
    }

    // If date type of field than compare it by converting to str to time format
    if (($bean->field_defs[$field]['type'] == 'date' || $bean->field_defs[$field]['type'] == 'datetime' || $bean->field_defs[$field]['type'] == 'datetimecombo') && $value_type != 'Date') {
        // If not a target module than date need to be converted to DB Format
        if (!$isTarget && $bean->field_defs[$field]['type'] != 'date') {
            $timedate = new TimeDate();
            // convert date to DB Format for comparing
            $bean_date = $timedate->to_db($bean->$field);
        }
        // Get only date in DB Format
        else if (!$isTarget && $bean->field_defs[$field]['type'] == 'date') {
            $timedate = new TimeDate();
            // convert date to DB Format for comparing
            $bean_date = $timedate->to_db_date($bean->$field, false);
        }
        // If target Module then date is already in DB Format
        else {
            $bean_date = isset($bean->$field) ? $bean->$field : $bean->fetched_row[$field];
        }

        $tobe_compare_value = strtotime($bean_date); // bean field to be compared
        $compare_value = strtotime($compare_value); // compare value
    }
    // Check value for Equals to
    if ($condition->condition_operator == 'Equal_To') {


        $GLOBALS['log']->debug("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for ' . $compare_value, 1));
        if (is_array($compare_value)) {
            if (in_array($tobe_compare_value, $compare_value)) {
                return true;
            }
        } else if ($tobe_compare_value == $compare_value) {
            return true;
        }
    }
    // Check value for Not Equals to
    else if ($condition->condition_operator == 'Not_Equal_To') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Not_Equal_To' . $compare_value, 1));
        if ($tobe_compare_value != $compare_value) {
            return true;
        }
    }
    // Check value forGreater Than
    else if ($condition->condition_operator == 'Greater_Than') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Greater_Than' . $compare_value, 1));
        if ((int) $tobe_compare_value > (int) $compare_value) {
            return true;
        }
    }
    // Check value for Less than
    else if ($condition->condition_operator == 'Less_Than') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Less_Than' . $compare_value, 1));
        if ((int) $tobe_compare_value < (int) $compare_value) {
            return true;
        }
    }
    // Check value for Greater than equals to
    else if ($condition->condition_operator == 'Greater_Than_or_Equal_To') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Greater_Than_or_Equal_To' . $compare_value, 1));
        if ((int) $tobe_compare_value >= (int) $compare_value) {
            return true;
        }
    }
    // Check value for Less than equals to
    else if ($condition->condition_operator == 'Less_Than_or_Equal_To') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Less_Than_or_Equal_To' . $compare_value, 1));
        if ((int) $tobe_compare_value <= (int) $compare_value) {
            return true;
        }
    }
    // Check value for Contais given string
    else if ($condition->condition_operator == 'Contains') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Contains' . $compare_value, 1));
        if (strpos($compare_value, $tobe_compare_value) !== false) {
            return true;
        }
    }
    // Check value for Starts with given string
    else if ($condition->condition_operator == 'Starts_With') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Starts with' . $condition->compare_value, 1));
        if (startsWith($tobe_compare_value, $compare_value)) {
            return true;
        }
    }
    // Check value for Ends with given string
    else if ($condition->condition_operator == 'Ends_With') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($tobe_compare_value . ' is....check for Ends with' . $condition->compare_value, 1));
        if (endsWith($tobe_compare_value, $compare_value)) {
            return true;
        }
    }
    return $result;
}

/*
 * this function is used for checking multi type conditions for given modules are met or not
 * 
 * @params
 * $condition - condition bean
 * $automizerId - automizer id
 * $bean - current bean
 * $execution_type - execution type
 */

function checkValueType_multi($condition, $automizerId, $bean, $execution_type) {
    $result = false;
    //compare value and saving value
    $field = $condition->condition_field; //Condition Field
    $compare_value = unencodeMultienum($condition->compare_value); // Comparing with Any of given Value
    // Check value for Equals to
    if ($condition->condition_operator == 'Equal_To') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($bean->$field . ' is....check for ' . $compare_value, 1));
        if (in_array($bean->$field, $compare_value)) {
            return true;
        }
    }
    // Check value for Not Equals to
    else if ($condition->condition_operator == 'Not_Equal_To') {

        $GLOBALS['log']->fatal("This is the checking of condition : " . print_r($bean->$field . ' is....check for Not_Equal_To' . $compare_value, 1));
        if (!in_array($bean->$field, $compare_value)) {
            return true;
        }
    }
    return $result;
}

/*
 * this function is used to get actions when conditions are true
 * 
 * @params
 * $automizerId - automizer id
 * $bean - current bean
 * $execution_type - execution type
 */

function send_survey_from_automizer_action($automizerId, $bean, $execution_type) {
    $oAutomizer = new bc_survey_automizer();
    $oAutomizer->retrieve($automizerId);
    $oAutomizer->load_relationship('bc_survey_automizer_bc_automizer_actions');

    foreach ($oAutomizer->bc_survey_automizer_bc_automizer_actions->getBeans() as $act) {
        // Send survey to Related module of target related module
        if ($act->recipient_type == 'related_related_module') {
            //get related bean Relationship
            $actionRelatedModule = $act->related_module;
            $relationship_name = $actionRelatedModule;


            //Retrieve related bean obj
            $bean->load_relationship($relationship_name);
            if ($bean->load_relationship($relationship_name)) {
                $getRelatedBean = $bean->$relationship_name->getBeans();
                if ($getRelatedBean) {

                    foreach ($getRelatedBean as $relatedClass) {
                        $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related bean of related's target : " . print_r($relatedClass->id, 1));
                        // if parent type of field from related module
                        if ($act->recipient_module == 'parent_name') {
                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the parent type field of action related related : " . print_r('', 1));
                            $survey_id = $act->survey_id;
                            $RelatedTo = $relatedClass->parent_type;
                            $RelatedToId = $relatedClass->parent_id;
                            if (empty($RelatedTo)) {
                                $RelatedTo = $relatedClass->module_name;
                            }
                            $allowed_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects');
                            if (in_array($RelatedTo, $allowed_modules)) {
                                $RelateBean = BeanFactory::getBean($RelatedTo, $RelatedToId);
                                // Send survey to All related records 
                                if (empty($act->filter_by) || $act->filter_by == 'all_related') {

                                    $email_address = $RelateBean->email1;
                                    $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the action from related parent all related.................................. : " . print_r($email_address, 1));
                                    if (!empty($RelatedToId)) {
                                        $module_id = $RelatedToId;
                                    } else {
                                        $module_id = create_guid();
                                        $RelateBean->id = $module_id;
                                        $RelateBean->new_with_id = true;
                                    }
                                    survey_submission_entry($module_id, $RelateBean, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                                }
                                // Send survey to those records whose conditions matches with action any related
                                else if ($act->filter_by == 'any_related') {
                                    $rel_field = $act->recipient_field;
                                    $operator = $act->recipient_operator;
                                    $value = $act->compare_value;
                                    // check value for bool type field
                                    if ($RelateBean->field_defs[$rel_field]['type'] == 'bool' && $value == 'bool_true') {
                                        $value = 1;
                                    } else if ($RelateBean->field_defs[$rel_field]['type'] == 'bool' && $value == 'bool_false') {
                                        $value = 0;
                                    }

                                    if (($operator == 'Equal_To' && $RelateBean->$rel_field == $value) || ($operator == 'Not_Equal_To' && $RelateBean->$rel_field != $value)) {
                                        $email_address = $RelateBean->email1;
                                        $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the action from related parent any related.................................. : " . print_r($email_address, 1));
                                        if (!empty($RelatedToId)) {
                                            $module_id = $RelatedToId;
                                        } else {
                                            $module_id = create_guid();
                                            $RelateBean->id = $module_id;
                                            $RelateBean->new_with_id = true;
                                        }
                                        survey_submission_entry($module_id, $RelateBean, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                                    }
                                }
                            } else {
                                $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: Related module $RelatedTo not match to send survey : " . print_r('', 1));
                            }
                        }
                        // If relationship field from related module
                        else {
                            // Related record detail
                            $relatedRelation = $act->recipient_module;
                            $relatedClass->load_relationship($act->recipient_module);
                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related related recipient module : " . print_r($act->recipient_module, 1));
                            if ($relatedClass->load_relationship($act->recipient_module)) {
                                $getRecipientBean = $relatedClass->$relatedRelation->getBeans();
                                if ($getRecipientBean) {

                                    foreach ($getRecipientBean as $recipientClass) {
                                        $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related related bean of related's target : " . print_r($recipientClass->id, 1));

                                        $survey_id = $act->survey_id;
                                        // Send survey to All related records 
                                        if (empty($act->filter_by) || $act->filter_by == 'all_related') {
                                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related related field filter by all related : " . print_r('', 1));
                                            $email_address = $recipientClass->email1;
                                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related relationship action all related.................................. : " . print_r($email_address, 1));
                                            if (!empty($recipientClass->id)) {
                                                $module_id = $recipientClass->id;
                                            }
                                            survey_submission_entry($module_id, $recipientClass, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                                        }
                                        // Send survey to those records whose conditions matches with action any related
                                        else if ($act->filter_by == 'any_related') {
                                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related related field filter by any related : " . print_r('', 1));
                                            $rel_field = $act->recipient_field;
                                            $operator = $act->recipient_operator;
                                            $value = $act->compare_value;
                                            // check value for bool type field
                                            if ($recipientClass->field_defs[$rel_field]['type'] == 'bool' && $value == 'bool_true') {
                                                $value = 1;
                                            } else if ($recipientClass->field_defs[$rel_field]['type'] == 'bool' && $value == 'bool_false') {
                                                $value = 0;
                                            }

                                            if (($operator == 'Equal_To' && $recipientClass->$rel_field == $value) || ($operator == 'Not_Equal_To' && $recipientClass->$rel_field != $value)) {
                                                $email_address = $recipientClass->email1;
                                                $GLOBALS['log']->fatal("This is the related relationship action any related.................................. : " . print_r($email_address, 1));
                                                if (!empty($recipientClass->id)) {
                                                    $module_id = $recipientClass->id;
                                                }
                                                survey_submission_entry($module_id, $recipientClass, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // Send survey to target module email field **************************************************
        if ($act->recipient_type == 'target_module' && $act->recipient_module == 'email1') {
            $survey_id = $act->survey_id;
            $email_address = $bean->email1;
            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the action.................................. : " . print_r($email_address, 1));
            if (!empty($bean->id)) {
                $module_id = $bean->id;
            } else {
                $module_id = create_guid();
                $bean->id = $module_id;
                $bean->new_with_id = true;
            }
            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the origin module id : " . print_r($module_id, 1));
            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the origin module name : " . print_r($bean->module_name, 1));
            survey_submission_entry($module_id, $bean, $survey_id, $execution_type, $act, $module_id, $bean->module_name, $bean);
        }
        // Send survey to target module email field **************************************************
        else if ($act->recipient_type == 'target_module' && $act->recipient_module == 'parent_name') {
            $survey_id = $act->survey_id;
            $RelatedTo = $bean->parent_type;
            $RelatedToId = $bean->parent_id;
            if (empty($RelatedTo)) {
                $RelatedTo = $bean->module_name;
            }
            $allowed_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects');
            if (in_array($RelatedTo, $allowed_modules)) {
                $RelateBean = BeanFactory::getBean($RelatedTo, $RelatedToId);
                $email_address = $RelateBean->email1;
                $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the action.................................. : " . print_r($email_address, 1));
                if (!empty($RelatedToId)) {
                    $module_id = $RelatedToId;
                } else {
                    $module_id = create_guid();
                    $RelateBean->id = $module_id;
                    $RelateBean->new_with_id = true;
                }
                survey_submission_entry($module_id, $RelateBean, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
            } else {
                $GLOBALS['log']->fatal("Related module $RelatedTo not match to send survey : " . print_r('', 1));
            }
        } else if ($act->recipient_type == 'target_module' && $act->recipient_module == 'target_parent_name') {
            $survey_id = $act->survey_id;
            $RelatedTo = $bean->target_parent_type;
            $RelatedToId = $bean->target_parent_id;
            if (empty($RelatedTo)) {
                $RelatedTo = $bean->module_name;
            }
            $allowed_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects');
            if (in_array($RelatedTo, $allowed_modules)) {
                $RelateBean = BeanFactory::getBean($RelatedTo, $RelatedToId);
                $email_address = $RelateBean->email1;
                $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the action taregt parent.................................. : " . print_r($email_address, 1));
                if (!empty($RelatedToId)) {
                    $module_id = $RelatedToId;
                } else {
                    $module_id = create_guid();
                    $RelateBean->id = $module_id;
                    $RelateBean->new_with_id = true;
                }
                survey_submission_entry($module_id, $RelateBean, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
            } else {
                $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: Related module $RelatedTo not match to send survey : " . print_r('', 1));
            }
        }
        // Send survey to related module *************************************************
        else if ($act->recipient_type == 'related_module') {
            //get related bean Relationship
            $actionRelatedModule = $act->recipient_module;
            $relationship_name = $actionRelatedModule;
            //Retrieve related bean obj
            $bean->load_relationship($relationship_name);
            if ($bean->load_relationship($relationship_name)) {
                $getRelatedBean = $bean->$relationship_name->getBeans();
                if ($getRelatedBean) {

                    foreach ($getRelatedBean as $relatedClass) {
                        // Send survey to All related records 
                        if (empty($act->filter_by) || $act->filter_by == 'all_related') {
                            $survey_id = $act->survey_id;
                            $email_address = $relatedClass->email1;
                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the related action.................................. : " . print_r($email_address, 1));
                            if (!empty($relatedClass->id)) {
                                $module_id = $relatedClass->id;
                            }
                            survey_submission_entry($module_id, $relatedClass, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                        }
                        // Send survey to those records whose conditions matches with action
                        else if ($act->filter_by == 'any_related') {
                            $rel_field = $act->recipient_field;
                            $operator = $act->recipient_operator;
                            $value = $act->compare_value;
                            // check value for bool type field
                            if ($relatedClass->field_defs[$rel_field]['type'] == 'bool' && $value == 'bool_true') {
                                $value = 1;
                            } else if ($relatedClass->field_defs[$rel_field]['type'] == 'bool' && $value == 'bool_false') {
                                $value = 0;
                            }

                            if (($operator == 'Equal_To' && $relatedClass->$rel_field == $value) || ($operator == 'Not_Equal_To' && $relatedClass->$rel_field != $value)) {
                                $survey_id = $act->survey_id;
                                $email_address = $relatedClass->email1;
                                $GLOBALS['log']->fatal("This is the related action.................................. : " . print_r($email_address, 1));
                                if (!empty($relatedClass->id)) {
                                    $module_id = $relatedClass->id;
                                }
                                survey_submission_entry($module_id, $relatedClass, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                            } else {
                                $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the action recipient condition not match for $relatedClass->id condition check for $rel_field match with $value : " . print_r('', 1));
                            }
                        }
                    }
                }
            }// can be a relate field
            else {
                $GLOBALS['log']->fatal("This is the else part of relationship : " . print_r('', 1));
                $survey_id = $act->survey_id;
                $allowed_modules = array('Accounts', 'Contacts', 'Leads', 'Prospects');
                $beanFields = $bean->field_defs;
                foreach ($beanFields as $field) {
                    if ($field['name'] == $act->recipient_module) {
                        if (in_array($field['module'], $allowed_modules)) {
                            $related_id_field = $field['id_name'];
                            $relatedId = $bean->$related_id_field;
                            $relatedBean = BeanFactory::getBean($field['module'], $relatedId);
                            $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the relate module {$field['module']} and field id {$relatedId} : " . print_r('', 1));
                            survey_submission_entry($relatedId, $relatedBean, $survey_id, $execution_type, $act, $bean->id, $bean->module_name, $bean);
                        }
                    }
                }
            }
        }
    }
}

/*
 * this function is used set survey submission entry to send survey
 * 
 * @params
 * $module_id - target module id
 * $bean - bean current
 * $survey_id - survey id
 * $execution_type - execution type
 * $act - action bean
 * $Origin_module_id - Origin module id
 * $Origin_module_name - Origin module name
 */

function survey_submission_entry($module_id, $bean, $survey_id, $execution_type, $act, $Origin_module_id, $Origin_module_name, &$SubmissionBean) {
    require_once 'custom/include/utilsfunction.php';
    $module_name = $bean->module_name;
    $recipient_as = $act->recipient_email_field;
    if ($SubmissionBean->module_dir == 'bc_survey_submission') {
        $Origin_module_name = $SubmissionBean->parent_type;
        $Origin_module_id = $SubmissionBean->parent_id;
    }
    $dataArray = sendSurveyEmailsModuleRecords($module_id, $module_name, $survey_id, '', '', true, $bean, $recipient_as, $Origin_module_name, $Origin_module_id, true);
    $GLOBALS['log']->fatal("setScheduledSurveysThruAutomation :: This is the survey submission entry : " . print_r($dataArray, 1));
    $survey_submission = new bc_survey_submission();
    $survey_submission->retrieve($dataArray['submission_id']);
    $resend = $survey_submission->resend;
    $resubmit = $survey_submission->resubmit;
    if ($dataArray['is_send'] == 'already_sent' && $dataArray['status'] == 'Submitted' && $resend == 0 && $resubmit == 0 && $execution_type == 'when_survey_scheduler_executes') {
        // Bug Fix : Resend survey to recipient via scheduler not quick send
        $survey_submission->resend = 1;
        $survey_submission->resubmit = 1;
        $survey_submission->save();
    }
}
