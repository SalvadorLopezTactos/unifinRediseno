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

require_once('include/resource/Observers/ResourceObserver.php');

/**
 * WebResourceObserver.php
 * This is a subclass of ResourceObserver to provide notification handling
 * for web clients.
 */
class WebResourceObserver extends ResourceObserver {

    /**
     * @deprecated Use __construct() instead
     */
    public function WebResourceObserver($module)
    {
        self::__construct($module);
    }

    public function __construct($module)
    {
        parent::__construct($module);
    }

/**
 * notify
 * Web implementation to notify the browser
 * @param msg String message to possibly display
 * 
 */
public function notify($msg = '') {
   echo $msg;
   sugar_cleanup(true);
}	
	
}
