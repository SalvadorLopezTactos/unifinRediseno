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
 * Created on Jul 17, 2006
 * Ajax Procedure for loading all subpanels for a certain subpanel tab.
 */

require_once('include/DetailView/DetailView.php');
$detailView = new DetailView();

$focus = BeanFactory::getBean($_REQUEST['loadModule']);
$focus->id = $_REQUEST['record'];

require_once('include/SubPanel/SubPanelTiles.php');
$subpanel = new SubPanelTiles($focus, $_REQUEST['loadModule']);

if(!function_exists('get_form_header')) {
    global $theme;

}

// set up data for subpanels
global $currentModule;
$currentModule = $_REQUEST['loadModule'];
$_REQUEST['action'] = 'DetailView';

//This line of code is critical.  We need to ensure that the global controller bean is set to the $currentModule global variable
$GLOBALS['app']->controller->bean = $focus;
echo $subpanel->display(false);
?>
