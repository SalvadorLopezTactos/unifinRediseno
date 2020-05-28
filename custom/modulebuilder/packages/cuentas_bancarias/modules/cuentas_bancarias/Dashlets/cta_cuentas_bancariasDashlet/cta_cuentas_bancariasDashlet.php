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

require_once('modules/cta_cuentas_bancarias/cta_cuentas_bancarias.php');

class cta_cuentas_bancariasDashlet extends DashletGeneric { 
    public function __construct($id, $def = null)
    {
		global $current_user, $app_strings;
		require('modules/cta_cuentas_bancarias/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'cta_cuentas_bancarias');

        $this->searchFields = $dashletData['cta_cuentas_bancariasDashlet']['searchFields'];
        $this->columns = $dashletData['cta_cuentas_bancariasDashlet']['columns'];

        $this->seedBean = new cta_cuentas_bancarias();        
    }
}