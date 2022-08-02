<?php

/**
 * The file used to set custom api related to survey sutomizer conditions
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

class bc_survey_conditionApi extends ModuleApi {

    public function registerApiRest() {
        return array(
            'getConditionModules' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'getConditionModules'),
                'pathVars' => array('', ''),
                'method' => 'getConditionModules',
                'shortHelp' => 'get survey automizer condition applicable modules',
                'longHelp' => '',
            ),
            'getConditionFields' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'getConditionFields'),
                'pathVars' => array('', ''),
                'method' => 'getConditionFields',
                'shortHelp' => 'get survey automizer fields of selected applicable module',
                'longHelp' => '',
            ),
            'saveConditions' => array(
                'reqType' => 'POST',
                'path' => array('bc_survey_condition', 'saveConditions'),
                'pathVars' => array('', ''),
                'method' => 'saveConditions',
                'shortHelp' => 'save conditions aplied to current automizer',
                'longHelp' => '',
            ),
            'getOperator' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'getOperator'),
                'pathVars' => array('', ''),
                'method' => 'getOperator',
                'shortHelp' => 'get oprators as per field selection for setting condition',
                'longHelp' => '',
            ),
            'getFieldTypeOptions' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'getFieldTypeOptions'),
                'pathVars' => array('', ''),
                'method' => 'getFieldTypeOptions',
                'shortHelp' => 'get Value type selection as per operator selected',
                'longHelp' => '',
            ),
            'getConditionValue' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'getConditionValue'),
                'pathVars' => array('', ''),
                'method' => 'getConditionValue',
                'shortHelp' => 'get Value as per value type selected',
                'longHelp' => '',
            ),
            'DisplayConditionList' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'DisplayConditionList'),
                'pathVars' => array('', ''),
                'method' => 'DisplayConditionList',
                'shortHelp' => 'List of conditions',
                'longHelp' => '',
            ),
            'removeCondition' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'removeCondition'),
                'pathVars' => array('', ''),
                'method' => 'removeCondition',
                'shortHelp' => 'Removes survey automizer condition and remove its relationship',
                'longHelp' => '',
            ),
            'getConditionRecord' => array(
                'reqType' => 'GET',
                'path' => array('bc_survey_condition', 'getConditionRecord'),
                'pathVars' => array('', ''),
                'method' => 'getConditionRecord',
                'shortHelp' => 'Get condition record from given condition id',
                'longHelp' => '',
            ),
        );
    }

    /**
     * Function : getConditionModules
     *    get survey automizer condition applicable modules
     * 
     * @return array - module_list
     */
    public function getConditionModules($api, $args) {
        require_once 'data/SugarBean.php';
        global $app_list_strings;
        $record = $args['record'];
        $oAutomizer = new bc_survey_automizer();
        $oAutomizer->retrieve($record);
        //get target module
        $dom_name = $oAutomizer->target_module;

        $type = 'field';
        $meta_filter_name = 'trigger_rel_filter';
        $focus = BeanFactory::getBean('Expressions');

        $_GET['opener_id'] = 'rel_module';
        $select_options = $focus->get_selector_array($type, '', $dom_name, true, $meta_filter_name, true, '', false);
        unset($_GET['opener_id']);

        $result_array = array();
        if (!empty($app_list_strings['moduleList'][$dom_name])) {
            $dom_name_label = $app_list_strings['moduleList'][$dom_name];
        } else {
            $dom_name_label = $dom_name;
        }

        $result_array[$dom_name] = $dom_name_label;

        foreach ($select_options as $key => $module) {
            if (!(strstr($key, 'bc_survey')) && $key != 'teams' && $key != 'favorite_link' && $key != 'following_link') {

                $result_array[$key] = $dom_name_label . ' : ' . $module;
            }
        }
        asort($result_array);

        return $result_array;
    }

    /**
     * Function : getConditionFields
     *    get survey automizer fields of selected applicable module
     * 
     * @return array - field_list
     */
    public function getConditionFields($api, $args) {
        global $app_list_strings;
        $record = $args['record_id'];
        $oAutomizer = new bc_survey_automizer();
        $oAutomizer->retrieve($record);
        //get target module
        $dom_name = $oAutomizer->target_module;
        // Relationship name
        $rel_mod_name = $args['rel_mod_name'];


        $dom_Obj = BeanFactory::getBean($dom_name);
        $dom_Obj->load_relationship($rel_mod_name);

        //Get Related module name from given relationship name
        if (!empty($dom_Obj->field_defs[$rel_mod_name]['module'])) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $dom_name) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module'])) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
        } else if (empty($rel_mod_name)) {
            $rel_mod_name = $args['rel_mod_name'];
        }

        $current_sel_field = $args['current_sel_field'];
        $all_field_curr = $args['all_field_curr'];

        $type = 'field';
        $meta_filter_name = 'normal_trigger';
        $trigger_type = 'compare_specific';
        $focus = BeanFactory::getBean('Expressions');
        $select_options = $focus->get_selector_array($type, '', $rel_mod_name, true, $meta_filter_name, true, $trigger_type, false);
        $result = array();
        global $app_strings;
        // retrieve date fields of module
        $arg_type = (!empty($args['type'])) ? $args['type'] : '';
        if ($arg_type != 'action') {
            $relatedBean = BeanFactory::getBean($rel_mod_name);
            $lang = return_module_language('en_us', $rel_mod_name);
            foreach ($relatedBean->field_defs as $key => $fields) {
                // check date field or not
                if ($fields['type'] == 'date' || $fields['type'] == 'datetime' || $fields['type'] == 'datetimecombo') {

                    $labelValue = trim($lang[$fields['vname']], ':');
                    if (empty($labelValue)) {
                        $labelValue = $app_strings[$fields['vname']];
                    }
                    $result[$key] = $labelValue;
                }
            }
        }
        // retrive all key value for fields when value_type is Field
        if (!empty($all_field_curr)) {
            foreach ($select_options as $key => $field) {
                if ($key != $all_field_curr && $key != 'picture') {
                    $options[$key] = $field;
                }
            }
            foreach ($result as $key => $field) {
                $options[$key] = $field;
            }
            asort($options);
            return $options;
        }
        // if already selected field or when value type is field then retrive label from key given
        if (!empty($current_sel_field)) {
            foreach ($result as $key => $field) {
                $select_options[$key] = $field;
            }
            foreach ($select_options as $key => $field) {
                if ($key == $current_sel_field) {
                    return $field;
                }
            }
        }

        foreach ($select_options as $key => $field) {
            if ($key != 'picture') {
                $result[$key] = $field;
            }
        }
        asort($result);

        return $result;
    }

    /**
     * Function : saveConditions
     *    save conditions aplied to current automizer
     * 
     * @return array - field_list
     */
    public function saveConditions($api, $args) {
        global $beanList, $current_user, $app_list_strings;
        //survey automizer record id
        $record_id = (!empty($args['record_id'])) ? $args['record_id'] : '';
        $condition_id = (!empty($args['condition_id'])) ? $args['condition_id'] : '';
        $filter_by = (!empty($args['filter_by'])) ? $args['filter_by'] : '';

        //retrieve current record conditions count

        $oAutomizer = new bc_survey_automizer();
        $oAutomizer->retrieve($record_id);
        $targetModule = $oAutomizer->target_module;
        if (empty($condition_id)) {
            $oAutomizer->load_relationship('bc_automizer_condition_bc_survey_automizer');
            $condition_orders = array();
            $count = 0;
            foreach ($oAutomizer->bc_automizer_condition_bc_survey_automizer->getBeans() as $con) {
                // $condition_orders[] = $con['condition_order'];
                array_push($condition_orders, $con->condition_order);
            }

            if (!empty($condition_orders)) {
                $count = max($condition_orders);
            }
            $count++;
        }
        if (ucfirst($args['module']) != $targetModule || $targetModule != $args['module']) {
            $module = $targetModule . ' : ' . $args['module'];
        } else {
            $module = ucfirst($args['module']);
        }

        $rel_module_name = $module;
        $current_sel_field = $args['field'];
        $operator = $args['operator'];

        $type = !empty($args['type']) ? $args['type'] : '';

        $value = $args['value'];

        if (is_array($value)) {
            foreach ($value as $k => $val) {
                if (!empty($val)) {
                    $con_value[$k] = '^' . $val . '^';
                    ;
                }
            }
            $compare_value = implode(',', $con_value);
        } else {
            $compare_value = $value;
        }

        if ($operator == 'is_null' || $operator == 'Any_Change') {
            $type = '';
            $compare_value = '';
        }
        //if value is from multi enum list options
        $dom_Obj = new $beanList[$targetModule]();
        $dom_Obj->load_relationship($args['module']);
        $rel_mod_name = $args['module'];

        //Get Related module name from given relationship name
        if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && $dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'] == 'many-to-many') {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
        } else if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && !empty($dom_Obj->$rel_mod_name->relationship->def['relationship_type']) && $dom_Obj->$rel_mod_name->relationship->def['relationship_type'] == 'one-to-many' && empty($field['link_type']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] == $dom_Obj->$rel_mod_name->relationship->def['rhs_module']) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $targetModule) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $targetModule && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'])) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module']) && !empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'])) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
        } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module']) && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && !empty($dom_Obj->$rel_mod_name->relationship->def['relationship_type'])) {
            $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
        } else if (empty($rel_mod_name)) {
            $rel_mod_name = ucfirst($args['rel_mod_name']);
        }

        $fielModule_Obj = BeanFactory::getBean($rel_mod_name);
        $rel_field_type = $fielModule_Obj->field_defs[$args['field']]['type'];

        if ($rel_field_type == 'date' && $type == 'Value') {
            //convert date into user timezone
            $timedate = new TimeDate();
            //  $datetime = new datetime($compare_value);
            $datetime = $timedate->to_db_date($compare_value, false);
            //  $only_date_array = explode(' ', $datetime->date);
            $compare_value = $datetime;
        } else if (($rel_field_type == 'datetime' || $rel_field_type == 'datetimecombo') && $type == 'Value') {
            //convert date into user timezone
            $timedate = new TimeDate();
            $datetime = $timedate->to_db($compare_value);
            //   $datetime = new datetime($compare_value);
            $compare_value = $datetime;
        }

        $oAutoCondition = new bc_automizer_condition();
        if (!empty($condition_id)) {
            $oAutoCondition->retrieve($condition_id);
        }
        $oAutoCondition->condition_module = $rel_module_name;
        $oAutoCondition->filter_by = $filter_by;
        $oAutoCondition->condition_field = $current_sel_field;
        $oAutoCondition->condition_operator = $operator;
        $oAutoCondition->value_type = $type;
        $oAutoCondition->compare_value = $compare_value;
        if (empty($condition_id)) {
            $oAutoCondition->condition_order = $count;
        }

        $oAutoCondition->save();

        //Relate Condition with Survey Automizer
        $oAutoCondition->load_relationship('bc_automizer_condition_bc_survey_automizer');
        $oAutoCondition->bc_automizer_condition_bc_survey_automizer->add($record_id);


        return $oAutoCondition->id;
    }

    /**
     * Function : getOperator
     *    get oprators as per field selection for setting condition
     * 
     * @return array - operator_list
     */
    public function getOperator($api, $args) {
        global $app_list_strings;
        $record = $args['record_id'];
        $oAutomizer = BeanFactory::getBean('bc_survey_automizer');
        $oAutomizer->retrieve($record);
        //get target module
        $dom_name = $oAutomizer->target_module;

        $rel_field = $args['rel_field'];
        $dom_Obj = BeanFactory::getBean($dom_name);
        $dom_Obj->load_relationship($rel_field);

        if (!empty($dom_Obj->field_defs[$rel_field]['module'])) {
            $rel_field = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_field]['module']];
        } else if (!empty($dom_Obj->$rel_field->relationship->def['lhs_module']) && $dom_Obj->$rel_field->relationship->def['lhs_module'] != $dom_name) {
            $rel_field = $app_list_strings['moduleList'][$dom_Obj->$rel_field->relationship->def['lhs_module']];
        } else if (!empty($dom_Obj->$rel_field->relationship->def['rhs_module'])) {
            $rel_field = $app_list_strings['moduleList'][$dom_Obj->$rel_field->relationship->def['rhs_module']];
        } else if (empty($rel_field)) {
            $rel_field = ($args['rel_field']);
        }

        global $app_list_strings, $beanFiles, $beanList;


        $target_module = $oAutomizer->target_module;

        if (isset($rel_field) && $rel_field != '') {
            $module = $rel_field;
        } else {
            $module = $target_module;
        }


        $fieldname = $args['selected_field'];

        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        if ($vardef) {

            switch ($vardef['type']) {
                case 'double':
                case 'decimal':
                case 'float':
                case 'currency':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'Greater_Than', 'Less_Than', 'Greater_Than_or_Equal_To', 'Less_Than_or_Equal_To', 'is_null', 'Any_Change');
                    break;
                case 'uint':
                case 'ulong':
                case 'long':
                case 'short':
                case 'tinyint':
                case 'int':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'Greater_Than', 'Less_Than', 'Greater_Than_or_Equal_To', 'Less_Than_or_Equal_To', 'is_null', 'Any_Change');
                    break;
                case 'date':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'Greater_Than', 'Less_Than', 'Greater_Than_or_Equal_To', 'Less_Than_or_Equal_To', 'is_null', 'Any_Change');
                    break;
                case 'datetime':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'Greater_Than', 'Less_Than', 'Greater_Than_or_Equal_To', 'Less_Than_or_Equal_To', 'is_null', 'Any_Change');
                    break;
                case 'datetimecombo':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'Greater_Than', 'Less_Than', 'Greater_Than_or_Equal_To', 'Less_Than_or_Equal_To', 'is_null', 'Any_Change');
                    break;
                case 'enum':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'is_null', 'Any_Change');
                    break;
                case 'multienum':
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'is_null', 'Any_Change');
                    break;

                default:
                    $valid_opp = array('Equal_To', 'Not_Equal_To', 'is_null', 'Any_Change');
                    break;
            }

            foreach ($app_list_strings['operator_list'] as $key => $keyValue) {
                if (!in_array($key, $valid_opp)) {
                    unset($app_list_strings['operator_list'][$key]);
                }
            }

            $app_list_strings['operator_list'];
            $result = array();
            foreach ($app_list_strings['operator_list'] as $key => $value) {
                $result[$key] = $value;
            }
            $result_array = array();
            $result_array['operator'] = $result;

            // get related field type
            $type = (!empty($args['type_selcted'])) ? $args['type_selcted'] : '';
            $FieldType = $this->getFieldTypeOptions($api, array('sel_fieldname' => $fieldname, 'rel_module' => $rel_field, 'record_id' => $record));
            $result_array['type'] = $FieldType['type'];

            // get related field type
            $value = (!empty($args['value_selected'])) ? $args['value_selected'] : '';
            $FieldValue = $this->getConditionValue($api, array('sel_fieldname' => $rel_field, 'rel_field' => $fieldname, 'record_id' => $record, 'sel_type' => $type));
            $result_array['value'] = $FieldValue;

            return $result_array;
        }
    }

    /**
     * Function : getFieldTypeOptions
     *    get oprators as per field selection for setting condition
     * 
     * @return array - operator_list
     */
    function getFieldTypeOptions($api, $args) {

        global $app_list_strings, $beanFiles, $beanList;

        $fieldname = $args['sel_fieldname'];
        $record = $args['record_id'];
        $oAutomizer = BeanFactory::getBean('bc_survey_automizer');
        $oAutomizer->retrieve($record);
        //get target module
        $dom_name = $oAutomizer->target_module;

        $module = $args['rel_module'];
        $dom_Obj = BeanFactory::getBean($dom_name);
        $dom_Obj->load_relationship($module);

        if (!empty($dom_Obj->field_defs[$module]['module'])) {
            $module = $app_list_strings['moduleList'][$dom_Obj->field_defs[$module]['module']];
        } else if (!empty($dom_Obj->$module->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $dom_name) {
            $module = $app_list_strings['moduleList'][$dom_Obj->$module->relationship->def['lhs_module']];
        } else if (!empty($dom_Obj->$module->relationship->def['rhs_module'])) {
            $module = $app_list_strings['moduleList'][$dom_Obj->$module->relationship->def['rhs_module']];
        } else if (empty($module)) {
            $module = ($args['rel_module']);
        }


        require_once($beanFiles[$beanList[$module]]);
        $focus = new $beanList[$module];
        $vardef = $focus->getFieldDefinition($fieldname);

        switch ($vardef['type']) {
            case 'double':
            case 'decimal':
            case 'float':
            case 'currency':
                $valid_opp = array('Value', 'Field');
                break;
            case 'uint':
            case 'ulong':
            case 'long':
            case 'short':
            case 'tinyint':
            case 'int':
                $valid_opp = array('Value', 'Field');
                break;
            case 'date':
                $valid_opp = array('Value', 'Field', 'Date');
                break;
            case 'datetime':
                $valid_opp = array('Value', 'Field', 'Date');
                break;
            case 'datetimecombo':
                $valid_opp = array('Value', 'Field', 'Date');
                break;
            case 'enum':
            case 'dynamicenum':
            case 'multienum':
                $valid_opp = array('Value', 'Field', 'Multi');
                break;
            case 'relate':
            case 'id':
                $valid_opp = array('Value', 'Field');
                break;
            default:
                $valid_opp = array('Value', 'Field');
                break;
        }


        foreach ($app_list_strings['value_type_list'] as $key => $keyValue) {
            if (!in_array($key, $valid_opp)) {
                unset($app_list_strings['value_type_list'][$key]);
            }
        }
        $result_array = array();
        $result_array['type'] = $app_list_strings['value_type_list'];

        // get related field type
        $value = $args['value_selected'];
        $FieldValue = $this->getConditionValue($api, array('sel_fieldname' => $module, 'rel_field' => $fieldname, 'record_id' => $record, 'sel_type' => $args['type_selcted']));
        $result_array['value'] = $FieldValue;

        return $result_array;
    }

    function getConditionValue($api, $args) {

        global $app_list_strings;

        if (isset($args['rel_field']) && $args['rel_field'] != '') {
            $rel_module = $args['rel_field'];
        }

        $record = $args['record_id'];
        $oAutomizer = new bc_survey_automizer();
        $oAutomizer->retrieve($record);
        //get target module
        $dom_name = $oAutomizer->target_module;

        $module = $args['sel_fieldname'];
        $dom_Obj = BeanFactory::getBean($dom_name);
        $dom_Obj->load_relationship($module);

        //Get Related module name from given relationship name
        if (!empty($dom_Obj->field_defs[$module]['module'])) {
            $module = $app_list_strings['moduleList'][$dom_Obj->field_defs[$module]['module']];
        } else if (!empty($dom_Obj->$module->relationship->def['lhs_module']) && $dom_Obj->$module->relationship->def['lhs_module'] != $dom_name) {
            $module = $app_list_strings['moduleList'][$dom_Obj->$module->relationship->def['lhs_module']];
        } else if (!empty($dom_Obj->$module->relationship->def['rhs_module'])) {
            $module = $app_list_strings['moduleList'][$dom_Obj->$module->relationship->def['rhs_module']];
        } else if (empty($module)) {
            $module = ($args['sel_fieldname']);
        }
        //
        $fieldname = $args['rel_field'];

        switch ($args['sel_type']) {
            case 'Field':
                $req['all_field_curr'] = $args['rel_field'];
                $req['rel_mod_name'] = $module;
                $req['record_id'] = $record;
                $result = '<select id="filter__field_value">' . get_select_options_with_id($this->getConditionFields($api, $req),'') . '</select>';

                break;
            case 'Date':
                $date_options = '';
                if (!empty($app_list_strings['automation_date_options_list'])) {
                    foreach ($app_list_strings['automation_date_options_list'] as $key => $option) {
                        $date_options .= '<option value="' . $key . '">' . $option . '</option>';
                    }
                } else {
                    $date_options = '<option value="Today">Today</option><option value="Last_Week">Last Week</option><option value="Last_30_Days">Last 30 Days</option><option value="Next_Week">Next Week</option><option value="Next_30_Days">Next 30 Days</option>';
                }

                $result = '<select id="filter__field_value" class="filter__field_value" name="filter__field_value" style="">' . $date_options . '</select>';
                break;
            case 'Multi':
                $result = $this->getModuleField($module, $fieldname, 'multiple');
                break;
            case 'Value':
            default:
                $result = $this->getModuleField($module, $fieldname);
                break;
        }

        return $result;
    }

    function getModuleField($module = '', $field = '', $multiple = '') {
        global $selector_meta_array;
        $exp_object = new Expression();
        $filter_array = $exp_object->build_field_filter($module, $field);
        if (!empty($multiple)) {
            $filter_array['value_select']['display'] = str_replace('<select ', '<select multiple ', $filter_array['value_select']['display']);
        }

        //Date field
        if ($filter_array['type'] == 'date') {
            return '<input id="filter__field_value" class="date_picker" placeholder="Date" name="filter__field_value" tabindex="1" size="25" maxlength="100" type="text" value="">';
        }
        // DateTime field
        else if ($filter_array['type'] == 'datetime' || $filter_array['type'] == 'datetimecombo') {
            return '<input id="filter__field_value" class="date_picker" placeholder="Date" name="filter__field_value" tabindex="1" size="25" maxlength="100" type="text" value="">&nbsp;<input id="filter__field_value" class="time_picker" placeholder="Time" name="filter__field_value" style="width:15%;" tabindex="1" size="10" maxlength="30" type="text" value="">';
        }
        // Other fields
        else {
            return $filter_array['value_select']['display'];
        }
    }

    function DisplayConditionList($api, $args) {

        global $app_list_strings, $current_user;
        $record_id = $args['record'];

        // Retrive Survey Automizer Target Module And Related Survey Automizer Conditions
        $oSurveyAutomizer = new bc_survey_automizer();
        $oSurveyAutomizer->retrieve($record_id);
        $targetModule = $oSurveyAutomizer->target_module;
        $oSurveyAutomizer->load_relationship('bc_automizer_condition_bc_survey_automizer');
        $count = 0;
        $list = array();
        foreach ($oSurveyAutomizer->bc_automizer_condition_bc_survey_automizer->getBeans() as $con) {
            //list of conditions
            $value = '';
            $value_type = '';
            $value_type_options = '';
            $module = explode(':', $con->condition_module);
            if (is_array($module) && !empty($module[1])) {
                $Conmodule = trim($module[1]);
            } else if (is_array($module) && empty($module[1])) {
                $Conmodule = trim($module[0]);
            } else {
                $Conmodule = $con->condition_module;
            }

            //Get Related module name from given relationship name
            $dom_Obj = BeanFactory::getBean($targetModule);
            $dom_Obj->load_relationship($Conmodule);
            if (!empty($dom_Obj->field_defs[$Conmodule]['module'])) {
                $Conmodule = $app_list_strings['moduleList'][$dom_Obj->field_defs[$Conmodule]['module']];
            } else if (!empty($dom_Obj->$Conmodule->relationship->def['lhs_module']) && $dom_Obj->$Conmodule->relationship->def['lhs_module'] != $targetModule) {
                $Conmodule = $app_list_strings['moduleList'][$dom_Obj->$Conmodule->relationship->def['lhs_module']];
            } else if (!empty($dom_Obj->$Conmodule->relationship->def['rhs_module'])) {
                $Conmodule = $app_list_strings['moduleList'][$dom_Obj->$Conmodule->relationship->def['rhs_module']];
            }

            $GetFieldsFromModule = (!empty($dom_Obj->field_defs[$Conmodule]['module'])) ? $dom_Obj->field_defs[$Conmodule]['module'] : '';
            if ($GetFieldsFromModule == $targetModule) {
                $Conmodule = (!empty($module[1])) ? trim($module[1]) : '';
            }

            $label_module = (!empty($module[1])) ? trim($module[1]) : '';
            if (empty($label_module)) {
                $label_module = (!empty($module[0])) ? trim($module[0]) : '';
            }
            $condition_module_array = $this->getConditionModules($api, array('record' => $record_id));
            $condition_module = $condition_module_array[$label_module];
            if (empty($condition_module)) {
                $condition_module = $condition_module_array[strtolower($label_module)];
            }
            //value type
            $value_type = !empty($app_list_strings['value_type_list'][$con->value_type]) ? $app_list_strings['value_type_list'][$con->value_type] : '';

            //if value is from multi enum list options
            $fielModule_Obj = BeanFactory::getBean(ucfirst($Conmodule));
            $GetFieldsFromFieldMod = (!empty($fielModule_Obj->field_defs[$con->condition_field]['options'])) ? $fielModule_Obj->field_defs[$con->condition_field]['options'] : '';
            $rel_field_type = (!empty($fielModule_Obj->field_defs[$con->condition_field]['type'])) ? $fielModule_Obj->field_defs[$con->condition_field]['type'] : '';
            if ($rel_field_type == 'team_list') {
                foreach (get_team_array() as $id => $team) {
                    if (!empty($con->compare_value) && $id == $con->compare_value) {
                        $value_type_options = $team;
                    }
                }
            }

            $rel_field_type = $fielModule_Obj->field_defs[$con->condition_field]['type'];

            if (!empty($GetFieldsFromFieldMod)) {
                $value_type_options = !empty($app_list_strings[$GetFieldsFromFieldMod][$con->compare_value]) ? $app_list_strings[$GetFieldsFromFieldMod][$con->compare_value] : $con->compare_value;
            }

            // get multiselect values
            $valueMulti = unencodeMultienum($con->compare_value);

            if (is_array($valueMulti) && !empty($valueMulti)) {
                $value_type_options = '';
                foreach ($valueMulti as $multiValue) {
                    if (!empty($multiValue)) {
                        $value_type_options .= !empty($app_list_strings[$GetFieldsFromFieldMod][$multiValue]) ? $app_list_strings[$GetFieldsFromFieldMod][$multiValue] : $con->compare_value;
                        $value_type_options .= ',';
                    }
                }
            }
            $value_type_options = rtrim($value_type_options, ',');

            // get Field name
            if ($value_type == 'Field') {
                $value = $this->getConditionFields($api, array('record_id' => $record_id, 'rel_mod_name' => trim($Conmodule), 'current_sel_field' => $con->compare_value));
            }
            // get user options
            else if ($value_type == 'Value' && ($con->condition_field == 'assigned_user_id' || $con->condition_field == 'created_by' || $con->condition_field == 'modified_user_id')) {

                $user_array = get_user_array(TRUE, "Active", $field_value, true);
                $value = $user_array[$con->compare_value];
            }
            // get bool value
            else if ($value_type == 'Value' && $con->compare_value == 'bool_true') {
                $value = 'Yes';
            }
            //get bool value
            else if ($value_type == 'Value' && $con->compare_value == 'bool_false') {
                $value = 'No';
            }
            // get currency value from id
            else if ($value_type == 'Value' && $con->condition_field == 'currency_id') {
                $currency = SugarCurrency::getCurrencyByID($con->compare_value);
                $value = $currency->name;
            }
            // get value from app list string
            else if (!empty($value_type_options)) {
                $value = $value_type_options;
            } else {
                $value = $con->compare_value;
            }
            if (empty($value_type)) {
                $value_type = '-';
            }
            if (empty($value)) {
                $value = '-';
            }

            // if date field

            if ($rel_field_type == 'date' && $value_type == 'Value') {  // check for date field
                $timedate = new TimeDate();
                $value = $value . " 00:00:00";
                $datetime = $timedate->to_display_date_time($value, true, false, $current_user);
                $value_date_time = explode(' ', $datetime);
                $value = $value_date_time[0];
            }
            //check for date & time field
            if (($rel_field_type == 'datetime' || $rel_field_type == 'datetimecombo') && $value_type == 'Value') {
                $timedate = new TimeDate();
                // $value = $value . " 00:00:00";
                $datetime = $timedate->to_display_date_time($value, true, true, $current_user);
                $value = $datetime;
            }
            // check new date options
            if (($rel_field_type == 'datetime' || $rel_field_type == 'datetimecombo' || $rel_field_type == 'date') && $value_type == 'Date') {
                $value = !empty($app_list_strings['automation_date_options_list'][$value]) ? $app_list_strings['automation_date_options_list'][$value] : $value;
            }

            $list[$con->condition_order] = array(
                'id' => $con->id,
                'module' => $condition_module,
                'field' => $this->getConditionFields($api, array('record_id' => $record_id, 'rel_mod_name' => trim($Conmodule), 'current_sel_field' => $con->condition_field)),
                'operator' => $app_list_strings['operator_list'][$con->condition_operator],
                'value_type' => $value_type,
                'value' => $value,
                'condition_order' => $con->condition_order
            );
            $count++;
        }

        return $list;
    }

    function removeCondition($api, $args) {
        $record_id = $args['record'];
        $parent_id = $args['parent_id'];

        $oCondition = new bc_automizer_condition();
        $oCondition->retrieve($record_id);

        //remove relatioships
        $oCondition->load_relationship('bc_automizer_condition_bc_survey_automizer');
        $oCondition->bc_automizer_condition_bc_survey_automizer->delete($oCondition->id, $parent_id);

        $oCondition->deleted = 1;
        $oCondition->save();

        if ($oCondition->save()) {
            return true;
        }
    }

    function getConditionRecord($api, $args) {
        global $app_list_strings, $beanList, $current_user;
        $condition_id = $args['condition_id'];

        $result = array();

        $oSurveyAutomizerCondition = new bc_automizer_condition();
        $oSurveyAutomizerCondition->retrieve($condition_id);
        $module = $oSurveyAutomizerCondition->condition_module;
        $filter_by = $oSurveyAutomizerCondition->filter_by;
        $field = $oSurveyAutomizerCondition->condition_field;
        $operator = $oSurveyAutomizerCondition->condition_operator;
        $value_type = $oSurveyAutomizerCondition->value_type;
        $value = $oSurveyAutomizerCondition->compare_value;

        $mValue = unencodeMultienum($value);
        if (is_array($mValue) && !empty($mValue) && count($mValue) > 1) {
            $value = '';
            foreach ($mValue as $multiValue) {
                $value .= $multiValue . ',';
            }
        }

        //details of conditions

        $condition_module_array = explode(':', $module);

        $targetModule = trim($condition_module_array[0]);
        if (empty($condition_module_array[1])) {
            $condition_module = $module;
        } else {
            $condition_module = $condition_module_array[1];
        }

        $result = array(
            'module' => trim($condition_module),
            'filter_by' => $filter_by,
            'field' => $field,
            'operator' => $operator,
            'value_type' => $value_type,
            'value' => $value
        );
        // get related module
        if (!empty($condition_module_array[1])) {
            $rel_mod_name = trim($condition_module);
            $dom_Obj = new $beanList[$targetModule]();
            $dom_Obj->load_relationship($rel_mod_name);

            //Get Related module name from given relationship name
            if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && $dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'] == 'many-to-many') {
                $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
            } else if (!empty($dom_Obj->field_defs[$rel_mod_name]['module']) && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && !empty($dom_Obj->$rel_mod_name->relationship->def['relationship_type']) && $dom_Obj->$rel_mod_name->relationship->def['relationship_type'] == 'one-to-many' && empty($field['link_type']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] == $dom_Obj->$rel_mod_name->relationship->def['rhs_module']) {
                $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->field_defs[$rel_mod_name]['module']];
            } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $targetModule) {
                $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
            } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['lhs_module']) && $dom_Obj->$rel_mod_name->relationship->def['lhs_module'] != $targetModule && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'])) {
                $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['lhs_module']];
            } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module']) && !empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type'])) {
                $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
            } else if (!empty($dom_Obj->$rel_mod_name->relationship->def['rhs_module']) && empty($dom_Obj->$rel_mod_name->relationship->def['true_relationship_type']) && !empty($dom_Obj->$rel_mod_name->relationship->def['relationship_type'])) {
                $rel_mod_name = $app_list_strings['moduleList'][$dom_Obj->$rel_mod_name->relationship->def['rhs_module']];
            } else if (empty($rel_mod_name)) {
                $rel_mod_name = ucfirst($args['rel_mod_name']);
            }

            $relBean = BeanFactory::getBean($rel_mod_name);

            $type = $relBean->field_defs[$field]['type'];
        } else {
            $relBean = BeanFactory::getBean($condition_module_array[0]);

            $type = $relBean->field_defs[$field]['type'];
        }
        // check for date field
        if ($type == 'date') {
            $timedate = new TimeDate();
            $value = $value . " 00:00:00"; // add h:i:s for getting full date-time
            $datetime = $timedate->to_display_date_time($value, true, false, $current_user);
            $value_date_time = explode(' ', $datetime);
            // again assign formated date to update
            if (!empty($value_date_time[0])) {
                $result['value'] = $value_date_time[0];
            }
        }
        //check for date & time field
        if ($type == 'datetime' || $type == 'datetimecombo') {
            $timedate = new TimeDate();
            $datetime = $timedate->to_display_date_time($value, true, true, $current_user);
            $value_date_time = explode(' ', $datetime);
            // again assign formated date and time to update
            $result['date'] = $value_date_time[0];
            $result['time'] = $value_date_time[1];
        }

        return $result;
    }

}
