<?php

global $theme;

if($theme){
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
} else {
	$image_path = 'themes/default/images/';
}

$admin_option_defs = array();
$admin_option_defs['Administration']['DashletCopy'] = array(
	$image_path.'Users', 'LBL_DASHLETCOPY_ADMIN', 'LBL_DASHLETCOPY_DESCRIPTION', './index.php?module=Users&action=DashletCopy'
	);
$admin_group_header[]= array('LBL_DASHLETCOPY_GROUP','',false,$admin_option_defs, 'LBL_DASHLETCOPY_GROUP_DESCRIPTION');

?>
