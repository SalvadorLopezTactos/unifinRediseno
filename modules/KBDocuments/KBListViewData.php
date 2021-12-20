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
require_once('include/ListView/ListViewData.php');
class KBListViewData extends ListViewData
{
	function getTotalCount($main_query){
		$count_query = $this->seed->create_list_count_query($main_query);
		$result = $GLOBALS['db']->query($count_query);
		if($row = $GLOBALS['db']->fetchByAssoc($result)){
		return $row['c'];
		}
		return 0;
	}
}
