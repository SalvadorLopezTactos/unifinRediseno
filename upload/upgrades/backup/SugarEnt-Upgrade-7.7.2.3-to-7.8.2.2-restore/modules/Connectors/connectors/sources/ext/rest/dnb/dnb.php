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

/*********************************************************************************
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/

require_once('include/connectors/sources/ext/rest/rest.php');

class ext_rest_dnb extends ext_rest {
    protected $_has_testing_enabled = true;

    public function __construct() {
        // Set this before the constructor so that the values aren't overridden
        $this->_required_config_fields = array(
            'dnb_username',
            'dnb_password',
            'dnb_env',
        );

        // Call the constructor now
        parent::__construct();

        // Finish the rest up
        $this->_enable_in_wizard = false;
        $this->_enable_in_hover = true;
        $this->_enable_in_admin_display = false;
        $this->_enable_in_admin_mapping = false;
    }

    /**
     * This method is called from the administration interface to run a test of the service
     * It is up to subclasses to implement a test and set _has_testing_enabled to true so that
     * a test button is rendered in the administration interface
     *
     * @return result boolean result of the test function
     */
    public function test() {
        $api = ExternalAPIFactory::loadAPI('Dnb', true);
        $api->setConnector($this);
        // Since we are testing we want to make sure that we use the test credentials
        // instead of what might already be set on the connector
        $api->setInTest();
        return $api->checkTokenValidity(false);
    }

    /*
     * getItem
     *
     * As the D&B connector does not have a true API call, we simply
     * override this abstract
     */
    public function getItem($args=array(), $module=null){}


    /*
     * getList
     *
     * As the D&B connector does not have a true API call, we simply
     * override this abstract method
     */
    public function getList($args=array(), $module=null){}

    /*
     *
     * Handles actions at the beginning of saveConfig().
     */
    public function preSaveConfig() {
        $api = ExternalAPIFactory::loadAPI('Dnb', true);
        $api->setConnector($this);
        $api->checkTokenValidity(true);
    }
}

?>
