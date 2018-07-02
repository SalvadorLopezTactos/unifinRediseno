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

 // $Id: wizard.php 18703 2006-12-15 09:42:43Z majed $

require_once('modules/Studio/config.php');
require_once('modules/Studio/wizards/StudioWizard.php');

$wizard = !empty($_REQUEST['wizard'])? $_REQUEST['wizard']: 'StudioWizard';

if(SugarAutoLoader::fileExists('modules/Studio/wizards/'. $wizard . '.php')){
	require_once('modules/Studio/wizards/'. $wizard . '.php');
	$thewiz = new $wizard();
}else{
	unset($_SESSION['studio']['lastWizard']);
	$thewiz = new StudioWizard();
}

if(!empty($_REQUEST['back'])){
    $thewiz->back();
}
if(!empty($_REQUEST['option'])){
	$thewiz->process($_REQUEST['option']);
}else{
	$thewiz->display();

}


