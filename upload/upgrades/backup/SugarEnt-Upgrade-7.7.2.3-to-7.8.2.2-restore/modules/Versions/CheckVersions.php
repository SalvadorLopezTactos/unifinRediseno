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
	//returns a list of components that are not of expected version
	function get_invalid_versions(){
		$invalid = array();
        $expect_versions = array();
        require('modules/Versions/ExpectedVersions.php');
		
		foreach($expect_versions as $expect){
			$version = BeanFactory::getBean('Versions');
			$result = $version->db->query("Select * from  $version->table_name  where  name='". $expect['name'] . "'");
			$valid = $version->db->fetchByAssoc($result);
			if($valid == null || ( !$version->is_expected_version($expect) && !empty($version->name) )){
		
				$invalid[$expect['name']] = $expect;
			}
		}
		return $invalid;
	}

?>