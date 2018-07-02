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

 // $Id: SugarAuthenticateUser.php 54098 2010-01-28 18:15:47Z jmertic $

/**
 * This file is where the user authentication occurs. No redirection should happen in this file.
 *
 */
class SugarAuthenticateUser{

	/**
	 * Does the actual authentication of the user and returns an id that will be used
	 * to load the current user (loadUserOnSession)
	 *
	 * @param STRING $name
	 * @param STRING $password
	 * @param STRING $fallback - is this authentication a fallback from a failed authentication
	 * @return STRING id - used for loading the user
	 */
	function authenticateUser($name, $password, $fallback=false)
	{
	    $row = User::findUserPassword($name, $password, "(portal_only IS NULL OR portal_only !='1') AND (is_group IS NULL OR is_group !='1') AND status !='Inactive'");

	    // set the ID in the seed user.  This can be used for retrieving the full user record later
		//if it's falling back on Sugar Authentication after the login failed on an external authentication return empty if the user has external_auth_disabled for them
		if (empty ($row) || !empty($row['external_auth_only'])) {
			return '';
		} else {
			return $row['id'];
		}
	}
	/**
	 * Checks if a user is a sugarLogin user
	 * which implies they should use the sugar authentication to login
	 *
	 * @param STRING $name
	 * @param STRIUNG $password
	 * @return boolean
	 */
	function isSugarLogin($name, $password)
	{
	    $row = User::findUserPassword($name, $password, "(portal_only IS NULL OR portal_only !='1') AND (is_group IS NULL OR is_group !='1') AND status !='Inactive' AND sugar_login=1");
	    return !empty($row);
	}

    /**
     * this is called when a user logs in
     *
     * @param STRING $name
     * @param STRING $password
     * @param STRING $fallback - is this authentication a fallback from a failed authentication
     *
     * @return boolean
     */
    function loadUserOnLogin($name, $password, $fallback = false, $PARAMS = array())
    {
        $passwordEncrypted = false;
        if (empty($name) && empty($password) && !empty($_REQUEST['MSID'])) {
            $user_id = $this->checkForSeamlessLogin($_REQUEST['MSID']);
        } else {
            $GLOBALS['log']->debug("Starting user load for " . $name);
            if (empty($name) || empty($password)) {
                return false;
            }
            $input_hash = $password;
            if (!empty($PARAMS) && isset($PARAMS['passwordEncrypted']) && $PARAMS['passwordEncrypted']) {
                $passwordEncrypted = true;
            }// if
            if (!$passwordEncrypted) {
                $input_hash = SugarAuthenticate::encodePassword($password);
            } // if
            $user_id = $this->authenticateUser($name, $input_hash, $fallback);
            if (empty($user_id)) {
                $GLOBALS['log']->fatal('SECURITY: User authentication for ' . $name . ' failed');

                return false;
            }
        }

        $this->loadUserOnSession($user_id);
        
        // Only call rehash when we have a clear text password
        if (!$passwordEncrypted && !empty($GLOBALS['current_user']->id)) {
            $GLOBALS['current_user']->rehashPassword($password);
        }

        return true;
    }

    /**
     * @param string $sessionId
     * @return bool
     */
    protected function checkForSeamlessLogin($sessionId)
    {
        //allow a user to pick up a session from another application.
        session_id($sessionId);
        session_start();
        if (isset($_SESSION['user_id']) && isset($_SESSION['seamless_login'])) {
            unset($_SESSION['seamless_login']);
            $sessionIp = null;
            if (isset($_SESSION['seamless_login_ip'])) {
                $sessionIp = $_SESSION['seamless_login_ip'];
                unset($_SESSION['seamless_login_ip']);
            } elseif (isset($_SESSION['ipaddress'])) {
                $sessionIp = $_SESSION['ipaddress'];
            }

            if ($sessionIp) {
                $clientIp = query_client_ip();
                if (!validate_ip($clientIp, $sessionIp)) {
                    $GLOBALS['log']->fatal(sprintf(
                        'Seamless login IP address mismatch: SESSION IP: %s, CLIENT IP: %s',
                        $_SESSION['seamless_login_ip'],
                        $clientIp
                    ));
                    session_write_close();
                                    $_SESSION = array();
                    return false;
                }
            }
            return $_SESSION['user_id'];
        }
        session_write_close();
                        $_SESSION = array();

        return false;
    }

	/**
	 * Loads the current user bassed on the given user_id
	 *
	 * @param STRING $user_id
	 * @return boolean
	 */
	function loadUserOnSession($user_id=''){
		if(!empty($user_id)){
			$_SESSION['authenticated_user_id'] = $user_id;
		}

		if(!empty($_SESSION['authenticated_user_id']) || !empty($user_id)){
			$GLOBALS['current_user'] = BeanFactory::getBean('Users');
			if($GLOBALS['current_user']->retrieve($_SESSION['authenticated_user_id'])){
				return true;
			}
		}
		return false;

	}

}


