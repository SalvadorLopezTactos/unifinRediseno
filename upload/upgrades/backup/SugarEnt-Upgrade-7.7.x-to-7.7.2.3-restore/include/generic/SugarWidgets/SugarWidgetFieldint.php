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


class SugarWidgetFieldInt extends SugarWidgetReportField
{
 function displayList($layout_def)
 {
        $rawField = parent::displayList($layout_def);
        $vardef = $this->reporter->all_fields[$layout_def['column_key']];

        if ($layout_def['type'] !== 'int' || !empty($vardef['disable_num_format'])) {
            return $rawField;
        }
        if ($rawField === '' || $rawField === null) {
            return '';
        }
        return format_number($rawField, 0, 0);
 }

 function queryFilterEquals(&$layout_def)
 {
                return $this->_get_column_select($layout_def)."= ".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterNot_Equals(&$layout_def)
 {
                return $this->_get_column_select($layout_def)."!=".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterGreater(&$layout_def)
 {
                return $this->_get_column_select($layout_def)." > ".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterLess(&$layout_def)
 {
                return $this->_get_column_select($layout_def)." < ".$GLOBALS['db']->quote($layout_def['input_name0'])."\n";
 }

 function queryFilterBetween(&$layout_def)
 {
 	             return $this->_get_column_select($layout_def)." BETWEEN ".$GLOBALS['db']->quote($layout_def['input_name0']). " AND " . $GLOBALS['db']->quote($layout_def['input_name1']) . "\n";
 }

    public function queryFiltergreater_equal(&$layout_def)
    {
        return $this->_get_column_select($layout_def) . " >= " . $GLOBALS['db']->quote($layout_def['input_name0']) . "\n";
    }

    public function queryFilterLess_Equal(&$layout_def)
    {
        return $this->_get_column_select($layout_def) . " <= " . $GLOBALS['db']->quote($layout_def['input_name0']) . "\n";
    }

 function queryFilterStarts_With(&$layout_def)
 {
 	return $this->queryFilterEquals($layout_def);
 }

 function displayInput(&$layout_def)
 {
 	 return '<input type="text" size="20" value="' . $layout_def['input_name0'] . '" name="' . $layout_def['name'] . '">';

 }
 
 function display($layout_def)
 {
	   //Bug40995
	   if(isset($obj->layout_manager->defs['reporter']->focus->field_name_map[$layout_def['name']]['precision']))
	   {
		   $precision=$obj->layout_manager->defs['reporter']->focus->field_name_map[$layout_def['name']]['precision'];
		   $layout_def['precision']=$precision;
	   }
	   //Bug40995
       return parent::display($layout_def);
 } 

}
