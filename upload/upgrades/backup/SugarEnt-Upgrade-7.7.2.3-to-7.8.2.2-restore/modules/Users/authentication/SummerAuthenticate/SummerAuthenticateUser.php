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

require_once('modules/Users/authentication/SugarAuthenticate/SugarAuthenticateUser.php');
class SummerAuthenticateUser extends SugarAuthenticateUser
{
    public function __construct()
    {
        $this->box = BoxOfficeClient::getInstance();
    }

	public function authenticateUser($username, $password)
	{
	    $user = $this->box->getCurrentUser();
	    if(empty($user)) return '';

	    $usr = new User();
		$usr_id = $usr->retrieve_user_id($username);
		if(empty($usr_id)) {
		    $usr_id = $this->createUser($user);
		}
		$usr->retrieve($usr_id);

		return $usr->id;
	}

	protected function createUser($userData)
	{
	    $user = new User();
	    $user->user_name = $userData['email'];
	    $user->email = $userData['email'];
	    $user->email1 = $userData['email'];
	    $user->first_name = $userData['first_name'];
	    $user->last_name = $userData['last_name'];
	    $user->status = 'Active';
	    $user->is_admin = 0;
	    $user->external_auth_only = 1;
	    $user->system_generated_password = 0;
	    $user->authenticate_id = $userData['remote_id'];
        $user->receive_notifications = 0;
	    if(!empty($userData['photo'])) {
	        $picid = create_guid();
	        if(copy($userData['photo'], "upload://$picid")) {
	            $user->picture = $picid;
	        }
	    }
        $user->id = 'rmt-'.md5($userData['remote_id']);
        $user->new_with_id = true;
        $user->save();
        $user->setPreference('ut', 1);
        $user->savePreferencesToDB();
        return $user->id;
	}

	/**
     * This is called when a user logs in
     *
     * @param string $name
     * @param string $password
     * @param boolean $fallback - is this authentication a fallback from a failed authentication
     * @param array $PARAMS
     * @return boolean
     */
    public function loadUserOnLogin($name, $password, $fallback = false, $PARAMS = array())
    {
        // provide dummy login and password to parent class so that authentication
        // process could go on
        return parent::loadUserOnLogin($name, 'summer', $fallback, $PARAMS);
    }
}