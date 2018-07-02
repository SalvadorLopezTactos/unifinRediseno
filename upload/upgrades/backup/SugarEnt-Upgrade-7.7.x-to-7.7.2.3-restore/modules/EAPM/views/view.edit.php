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

class EAPMViewEdit extends ViewEdit {

    private $_returnId;

    public function __construct()
    {
        $this->setReturnId();
        parent::__construct();
    }

    protected function setReturnId()
    {
        $returnId = $GLOBALS['current_user']->id;
        if(!empty($_REQUEST['user_id']) && !empty($_REQUEST['return_module']) && 'Users' == $_REQUEST['return_module']){
            $returnId = $_REQUEST['user_id'];
        }
        $this->_returnId = $returnId;
    }

    protected function _getModuleTab()
    {
        return 'Users';
    }

    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;

        $returnAction = 'DetailView';
        $returnModule = 'Users';
        $returnId = $this->bean->assigned_user_id;
        $returnName = $this->bean->assigned_user_name;
        if(!empty($_REQUEST['return_action']) && !empty($_REQUEST['return_module'])){
            if('Users' == $_REQUEST['return_module']){
                if('EditView' == $_REQUEST['return_action']){
                    $returnAction = 'EditView';
                }
                if(!empty($_REQUEST['return_name'])){
                    $returnName = $_REQUEST['return_name'];
                }
                if(!empty($_REQUEST['user_id'])){
                    $returnId = $_REQUEST['user_id'];
                }
            }
        }
        $this->_returnId = $returnId;

        $iconPath = $this->getModuleTitleIconPath($this->module);
        $params = array();
        if (!empty($iconPath) && !$browserTitle) {
            $params[] = "<a href='index.php?module=Users&action=index'><!--not_in_theme!--><img src='{$iconPath}' alt='".translate('LBL_MODULE_NAME','Users')."' title='".translate('LBL_MODULE_NAME','Users')."' align='absmiddle'></a>";

        }
        else {
            $params[] = translate('LBL_MODULE_NAME','Users');
        }
        $params[] = "<a href='index.php?module={$returnModule}&action=EditView&record={$returnId}'>".$returnName."</a>";
        $params[] = $GLOBALS['app_strings']['LBL_EDIT_BUTTON_LABEL'];

        return $params;
    }

    /**
	 * @see SugarView::getModuleTitleIconPath()
	 */
	protected function getModuleTitleIconPath($module) 
    {
        return parent::getModuleTitleIconPath('Users');
    }

 	function display() {
        $this->bean->password = empty($this->bean->password) ? '' : EAPM::$passwordPlaceholder;

        $this->ss->assign('return_id', $this->_returnId);

        $cancelUrl = "index.php?action=EditView&module=Users&record={$this->_returnId}#tab5";

        if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Import') {
            $cancelUrl = "index.php?module=Import&action=Step1&import_module=". $_REQUEST['return_action'] . "&application=" . $_REQUEST['application'];
        }
         $this->ss->assign('cancelUrl', $cancelUrl);

        if($GLOBALS['current_user']->is_admin || empty($this->bean) || empty($this->bean->id) || $this->bean->isOwner($GLOBALS['current_user']->id)){
            if(!empty($this->bean) && empty($this->bean->id) && $this->_returnId != $GLOBALS['current_user']->id){
                $this->bean->assigned_user_id = $this->_returnId;
            }
            
            parent::display();
        } else {
        	ACLController::displayNoAccess();
        }
 	}
}
