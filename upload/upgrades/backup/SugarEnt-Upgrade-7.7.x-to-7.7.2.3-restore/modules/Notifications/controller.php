<?php
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
require_once('modules/Notifications/Notifications.php');

/**
 * @deprecated Since 7.5 will be removed on 7.8
 */
class NotificationsController extends SugarController
{
    var $action_remap = array ( ) ;

    /**
     * @deprecated Since 7.5 will be removed on 7.8
     */
    public function __construct()
    {
        $GLOBALS['log']->deprecated('Notifications/controller.php is deprecated');
        parent::SugarController();
    }
}
