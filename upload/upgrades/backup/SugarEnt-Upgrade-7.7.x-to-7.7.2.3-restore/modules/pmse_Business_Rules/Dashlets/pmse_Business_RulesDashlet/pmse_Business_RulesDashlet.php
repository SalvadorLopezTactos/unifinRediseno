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
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/pmse_Business_Rules/pmse_Business_Rules.php');

class pmse_Business_RulesDashlet extends DashletGeneric { 
    function pmse_Business_RulesDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/pmse_Business_Rules/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'pmse_Business_Rules');

        $this->searchFields = $dashletData['pmse_Business_RulesDashlet']['searchFields'];
        $this->columns = $dashletData['pmse_Business_RulesDashlet']['columns'];

        $this->seedBean = new pmse_Business_Rules();        
    }
}