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
require_once('data/SugarACLStrategy.php');

/**
 * This class is used to enforce ACLs on modules that are restricted to admins only.
 */
class SugarACLAdminOnly extends SugarACLStrategy
{
    protected $allowUserRead = false;
    protected $adminFor = '';

    public function __construct($aclOptions)
    {
        if ( is_array($aclOptions) ) {
            if ( !empty($aclOptions['allowUserRead']) ) {
                $this->allowUserRead = true;
            }
            if ( !empty($aclOptions['adminFor']) ) {
                $this->adminFor = $aclOptions['adminFor'];
            }
        }
    }

    /**
     * Only allow access to users with the user admin setting
     * @param string $module
     * @param string $view
     * @param array $context
     * @return bool|void
     */
    public function checkAccess($module, $view, $context)
    {
        if ( $view == 'team_security' ) {
            // Let the other modules decide
            return true;
        }

        if ( !empty($this->adminFor) ) {
            $module = $this->adminFor;
        }
        
        $current_user = $this->getCurrentUser($context);
        if ( !$current_user ) {
            return false;
        }

        if($current_user->isAdminForModule($module)) {
            return true;
        } else {
            if ( $this->allowUserRead && !$this->isWriteOperation($view, $context) ) {
                return true;
            } else {
                return false;
            }
        }
    }

}
