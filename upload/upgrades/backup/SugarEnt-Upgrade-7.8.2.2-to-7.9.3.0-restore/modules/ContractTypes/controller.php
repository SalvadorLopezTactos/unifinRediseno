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

use Sugarcrm\Sugarcrm\Security\InputValidation\Request;

class ContractTypesController extends SugarController {

    /**
     * @deprecated Use __construct() instead
     */
    public function ContractTypesController(Request $request = null)
    {
        self::__construct($request);
    }

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

	public function process(){
        if((!is_admin($GLOBALS['current_user']) && (!is_admin_for_module($GLOBALS['current_user'],'Contracts')))){ 
			$this->hasAccess = false;
		}
		parent::process();
	}
	
}
