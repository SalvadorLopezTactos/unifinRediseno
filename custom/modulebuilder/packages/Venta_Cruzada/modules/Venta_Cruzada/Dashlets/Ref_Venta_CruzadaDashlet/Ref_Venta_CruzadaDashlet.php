<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
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

require_once('modules/Ref_Venta_Cruzada/Ref_Venta_Cruzada.php');

class Ref_Venta_CruzadaDashlet extends DashletGeneric { 
    public function __construct($id, $def = null)
    {
		global $current_user, $app_strings;
		require('modules/Ref_Venta_Cruzada/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'Ref_Venta_Cruzada');

        $this->searchFields = $dashletData['Ref_Venta_CruzadaDashlet']['searchFields'];
        $this->columns = $dashletData['Ref_Venta_CruzadaDashlet']['columns'];

        $this->seedBean = new Ref_Venta_Cruzada();        
    }
}