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
/*********************************************************************************

 * Description:  
 ********************************************************************************/





$workflow = BeanFactory::getBean('WorkFlow');
if(isset($_REQUEST['workflow_id']) && isset($_REQUEST['record_id']))
{
	$alert_shell = BeanFactory::getBean('WorkFlowAlertShells', $_REQUEST['record_id']);
	$alert_shell->copy($_REQUEST['workflow_id']);
	
	$javascript = "<script>window.opener.document.DetailView.action.value = 'DetailView';";
	$javascript .= "window.opener.document.DetailView.submit();";
	$javascript .= "window.close();</script>";
	echo $javascript;
}
?>
