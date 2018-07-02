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

class SugarWidgetFieldVarchar extends SugarWidgetReportField
{
 function SugarWidgetFieldVarchar(&$layout_manager) 
 {
        parent::SugarWidgetReportField($layout_manager);
 }
 
 function queryFilterEquals(&$layout_def)
 {
		return $this->_get_column_select($layout_def)."='".$GLOBALS['db']->quote($layout_def['input_name0'])."'\n";
 }

 function queryFilterNot_Equals_Str(&$layout_def)
 {
		return $this->_get_column_select($layout_def)."!='".$GLOBALS['db']->quote($layout_def['input_name0'])."'\n";
 }

 function queryFilterContains(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." LIKE '%".$GLOBALS['db']->quote($layout_def['input_name0'])."%'\n";
 }
  function queryFilterdoes_not_contain(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." NOT LIKE '%".$GLOBALS['db']->quote($layout_def['input_name0'])."%'\n";
 }

 function queryFilterStarts_With(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." LIKE '".$GLOBALS['db']->quote($layout_def['input_name0'])."%'\n";
 }

 function queryFilterEnds_With(&$layout_def)
 {
		return $this->_get_column_select($layout_def)." LIKE '%".$GLOBALS['db']->quote($layout_def['input_name0'])."'\n";
 }
 
 function queryFilterone_of(&$layout_def)
 {
    foreach($layout_def['input_name0'] as $key => $value) {
        $layout_def['input_name0'][$key] = $GLOBALS['db']->quote($value); 
    }
    return $this->_get_column_select($layout_def) . " IN ('" . implode("','", $layout_def['input_name0']) . "')\n";
 }
  
 function displayInput(&$layout_def) 
 {
 		$str = '<input type="text" size="20" value="' . $layout_def['input_name0'] . '" name="' . $layout_def['name'] . '">';
 		return $str;
 }
}

?>
