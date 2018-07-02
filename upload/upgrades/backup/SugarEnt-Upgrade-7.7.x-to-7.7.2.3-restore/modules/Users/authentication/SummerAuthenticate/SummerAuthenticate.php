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
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticate.php');

class SummerAuthenticate extends SugarAuthenticate
{
	var $userAuthenticateClass = 'SummerAuthenticateUser';
	var $authenticationDir = 'SummerAuthenticate';

	public function __construct()
	{
		parent::SugarAuthenticate();
		$this->box = BoxOfficeClient::getInstance();
	}

    public function pre_login()
    {
        parent::pre_login();
        // go straight to authentication
        $token = $this->box->getToken();
        unset($_REQUEST['login_token']);
        SugarApplication::redirect("?module=Users&action=Authenticate&token=$token&".http_build_query($GLOBALS['app']->getLoginVars(false)));
    }

    public function loginAuthenticate()
    {
        $user = $this->box->getCurrentUser();
        if(empty($user)) {
            SugarApplication::redirect($this->box->loginUrl());
        }
        if(parent::loginAuthenticate($user['email'], '', false)) {
            // delete session when done
            // $this->box->deleteSession();
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
        ob_clean();
        $this->box->deleteSession();
        SugarApplication::redirect($this->box->loginUrl());
    }
}