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
        parent::__construct();
        $this->_enable_in_wizard = false;
        $this->_enable_in_hover = true;
        $this->_enable_in_admin_display = false;
        $this->_enable_in_admin_mapping = false;
        $this->_required_config_fields = array('dnb_username', 'dnb_password');
    }

    public function test() {
        $api = ExternalAPIFactory::loadAPI('Dnb', true);
        return $api->checkTokenValidity();
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
}

?>
