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

require_once 'clients/base/api/CurrentUserApi.php';

class CurrentUserMobileApi extends CurrentUserApi {
    /**
     * @param User $user
     *
     * @return string
     */
    protected function getUserHash($user)
    {
        $hash = parent::getUserHash($user);
        //Mix in the mobile tabs as User::getUserMDHash only takes the base tabs into account
        $metadataManagerClass = MetaDataManager::getManagerClassName('mobile');
        $tabs = call_user_func($metadataManagerClass . '::getTabList');

        return md5($hash . serialize($tabs));
    }
}
