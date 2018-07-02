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



class Group extends User {
	// User attribute overrides
	var $status			= 'Group';
	var $password		= ''; // to disallow logins
	var $default_team;
	var $importable = false;


    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function Group()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
	}

	/** 
	 * overrides SugarBean method
	 */
	function mark_deleted($id) {
		SugarBean::mark_deleted($id);
	}
} // end class def 
