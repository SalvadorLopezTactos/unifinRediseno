<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$style='embeded';
if(isset($_REQUEST['style'])){
	$style = $_REQUEST['style'];	
}
if(isset($_REQUEST['module_name'])){
    $module_name = $_REQUEST['module_name'];

    $module_name_htmlescaped = htmlspecialchars($module_name);
    $lbl_module_name_htmlescaped = htmlspecialchars($mod_strings['LBL_MODULE_NAME']);

    $the_strings = return_module_language($current_language, $module_name);

	global $app_strings;
	global $app_list_strings;
	global $mod_strings;
	global $current_user;

    echo SugarThemeRegistry::current()->getCSS();
    echo getClassicModuleTitle($lbl_module_name_htmlescaped, [$lbl_module_name_htmlescaped, $module_name_htmlescaped], true);

	$xtpl=new XTemplate ('modules/LabelEditor/EditView.html');
	$xtpl->assign("MOD", $mod_strings);
	$xtpl->assign("APP", $app_strings);
    $xtpl->assign("MODULE_NAME", $module_name_htmlescaped);
	$xtpl->assign("STYLE",$style);
	if(isset($_REQUEST['sugar_body_only'])){
		$xtpl->assign("SUGAR_BODY_ONLY",$_REQUEST['sugar_body_only']);
	}
	
	if(isset($_REQUEST['record']) ){
		$xtpl->assign("NO_EDIT", "readonly");
		$xtpl->assign("KEY", $_REQUEST['record']);
		if(isset($the_strings[$_REQUEST['record']])){
			$xtpl->assign("VALUE",$the_strings[$_REQUEST['record']]);
		}else{
			if(isset($_REQUEST['value']) )$xtpl->assign("VALUE", $_REQUEST['value']);	
		}
	}
	if($style == 'popup'){
		$xtpl->parse("main.popup");
	}
	$xtpl->parse("main");
	$xtpl->out("main");

}
else{
	echo 'No Module Selected';
}	



?>