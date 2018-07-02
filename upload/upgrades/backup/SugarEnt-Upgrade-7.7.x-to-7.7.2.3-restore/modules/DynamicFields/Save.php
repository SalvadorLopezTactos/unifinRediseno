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

require_once('modules/DynamicFields/DynamicField.php');

$module = $_REQUEST['module_name'];
$custom_fields = new DynamicField($module);
if(!empty($module)){
    $mod = BeanFactory::getBean($module);
	$custom_fields->setup($mod);
}else{
	echo "\n".$mod_strings['ERR_NO_MODULE_INCLUDED'];
}
$name = $_REQUEST['field_label'];
$options = '';
if($_REQUEST['field_type'] == 'enum'){
	$options = $_REQUEST['options'];
}
$default_value = '';

$custom_fields->addField($name,$name, $_REQUEST['field_type'],'255','optional', $default_value, $options, '', '' );
$html = $custom_fields->getFieldHTML($name, $_REQUEST['file_type']);

set_register_value('dyn_layout', 'field_counter', $_REQUEST['field_count']);
$label = $custom_fields->getFieldLabelHTML($name, $_REQUEST['field_type']);
require_once('modules/DynamicLayout/AddField.php');
$af = new AddField();
$af->add_field($name, $html,$label, 'window.opener.');
echo $af->get_script('window.opener.');
echo "\n<script>window.close();</script>";

?>
