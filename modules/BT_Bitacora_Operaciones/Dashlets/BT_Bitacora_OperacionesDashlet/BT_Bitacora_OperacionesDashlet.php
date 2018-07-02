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
require_once('modules/BT_Bitacora_Operaciones/BT_Bitacora_Operaciones.php');

class BT_Bitacora_OperacionesDashlet extends DashletGeneric { 
    function BT_Bitacora_OperacionesDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/BT_Bitacora_Operaciones/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'BT_Bitacora_Operaciones');

        $this->searchFields = $dashletData['BT_Bitacora_OperacionesDashlet']['searchFields'];
        $this->columns = $dashletData['BT_Bitacora_OperacionesDashlet']['columns'];

        $this->seedBean = new BT_Bitacora_Operaciones();        
    }
}