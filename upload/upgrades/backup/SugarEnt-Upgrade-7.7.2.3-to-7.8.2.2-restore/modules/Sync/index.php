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


if(!isset( $sugar_config['disc_client']) || !$sugar_config['disc_client']){
	die('Please convert this instance to a client');
}
global $soapclient, $soap_server;
if(isset($_GET['check_available'])){

		$start_time = $soapclient->call('get_gmt_time',array());

		if($start_time){
			 header("Location: index.php?action=index&module=Sync&go_online=1");
		}else{
			$_SESSION['soap_server_available'] = false;
			echo '<b><font color="red">'. translate('LBL_SERVER_UNAVAILABLE','Sync' ) .'</font></b>';
			die();
		}


}
if(isset($_REQUEST['go_online'])){
	session_start();
	global $current_user;

	if(!isset($current_user)){

		$current_user = BeanFactory::getBean('Users');
		if(isset($_SESSION['authenticated_user_id']))
		{
			$result = $current_user->retrieve($_SESSION['authenticated_user_id']);
			if($result == null)
			{
				session_destroy();
			    header("Location: index.php?action=Login&module=Users");
			}
		}
	}

	require_once('modules/Sync/SyncHelper.php');
	$soapclient = new nusoapclient($soap_server);  //define the SOAP Client an
	$result = $soapclient->call('login',array('user_auth'=>sync_get_user_auth_data(), 'application_name'=>'MobileClient'));

	if(!has_error($result)){
		$canlogin = $soapclient->call('seamless_login',array('session'=>$result['id']));
		if($canlogin == 1){
			header('Location:' . $sugar_config['sync_site_url'] . '/index.php?MSID='. $result['id']);
		}else{
			sugar_die('Could not do seamless login');
		}
	}
}

?>
