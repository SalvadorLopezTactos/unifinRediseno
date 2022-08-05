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
require_once('modules/TCT1_P_Fideicomiso/TCT1_P_Fideicomiso.php');

class TCT1_P_FideicomisoDashlet extends DashletGeneric { 
    function TCT1_P_FideicomisoDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/TCT1_P_Fideicomiso/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'TCT1_P_Fideicomiso');

        $this->searchFields = $dashletData['TCT1_P_FideicomisoDashlet']['searchFields'];
        $this->columns = $dashletData['TCT1_P_FideicomisoDashlet']['columns'];

        $this->seedBean = new TCT1_P_Fideicomiso();        
    }
}