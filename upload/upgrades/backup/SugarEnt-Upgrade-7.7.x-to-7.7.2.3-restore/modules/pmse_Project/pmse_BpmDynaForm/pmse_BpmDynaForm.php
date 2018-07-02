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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */

require_once 'modules/pmse_Project/pmse_BpmDynaForm/pmse_BpmDynaForm_sugar.php';

class pmse_BpmDynaForm extends pmse_BpmDynaForm_sugar {

	/**
	 * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @depreciated
	 */
	function pmse_BpmDynaForm(){
		self::__construct();
	}

	public function __construct(){
		parent::__construct();
	}

	/**
	 * @inheritDoc
	 */
	public function ACLAccess($view, $context = null)
	{
		switch ($view) {
			case 'list':
				if (is_array($context)
					&& isset($context['source'])
					&& $context['source'] === 'filter_api') {
					return false;
				}
				break;
			case 'edit':
			case 'view':
				if (is_array($context)
					&& isset($context['source'])
					&& $context['source'] === 'module_api') {
					return false;
				}
				break;
		}
		return parent::ACLAccess($view, $context);
	}

}
?>
