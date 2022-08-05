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

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/uni_poderes/uni_poderes.php');

class uni_poderesDashlet extends DashletGeneric { 
    function uni_poderesDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/uni_poderes/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'uni_poderes');

        $this->searchFields = $dashletData['uni_poderesDashlet']['searchFields'];
        $this->columns = $dashletData['uni_poderesDashlet']['columns'];

        $this->seedBean = new uni_poderes();        
    }
}