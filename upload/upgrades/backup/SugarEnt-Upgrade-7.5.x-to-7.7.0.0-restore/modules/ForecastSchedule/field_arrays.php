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

 * Description:  Contains field arrays that are used for caching
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
$fields_array['ForecastSchedule'] = array ('column_fields' => 
	array('id'
		,'timeperiod_id'
		,'user_id'
		,'cascade_hierarchy'
		,'forecast_start_date'
		,'status'
		,'date_entered'
		,'date_modified'
		,'created_by'
		),
        'list_fields' =>  array('id', 'timeperiod_id', 'user_id', 'date_entered', 'name', 
								'start_date','end_date','forecast_type'),
);
?>