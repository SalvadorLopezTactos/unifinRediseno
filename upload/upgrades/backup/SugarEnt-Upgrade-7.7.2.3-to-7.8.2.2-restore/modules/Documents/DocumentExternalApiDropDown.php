<?php
if(!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
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
function getDocumentsExternalApiDropDown($focus = null, $name = null, $value = null, $view = null) {
    require_once('include/externalAPI/ExternalAPIFactory.php');

    $apiList = ExternalAPIFactory::getModuleDropDown('Documents');

    $apiList = array_merge(array('Sugar'=>$GLOBALS['app_list_strings']['eapm_list']['Sugar']),$apiList);
    if(!empty($value) && empty($apiList[$value])){
        $apiList[$value] = $value;
    }
    return $apiList;

}
 
