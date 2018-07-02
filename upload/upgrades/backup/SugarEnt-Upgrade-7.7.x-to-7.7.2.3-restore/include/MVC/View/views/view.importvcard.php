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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
require_once('include/vCard.php');

class ViewImportvcard extends SugarView
{
    public $type = 'edit';
 	
	/**
     * @see SugarView::display()
     */
	public function display()
    {
        global $mod_strings, $app_strings;

        $this->ss->assign("ERROR_TEXT", $app_strings['LBL_EMPTY_VCARD']);
        if (isset($_REQUEST['error'])) {
            switch ($_REQUEST['error']) {
                case 'vcardErrorFilesize':
                    $error = 'LBL_VCARD_ERROR_FILESIZE';
                    break;
                case 'vcardErrorRequired':
                    $error = 'LBL_EMPTY_REQUIRED_VCARD';
                    break;
                default:
                    $error = 'LBL_VCARD_ERROR_DEFAULT';
                    break;
            }
            $this->ss->assign("ERROR", $app_strings[$error]);
        }
        $this->ss->assign("HEADER", $app_strings['LBL_IMPORT_VCARD']);
        $this->ss->assign("MODULE", $_REQUEST['module']);
        $params = array();
        $params[] = "<a href='index.php?module={$_REQUEST['module']}&action=index'>{$mod_strings['LBL_MODULE_NAME']}</a>";
        $params[] = $app_strings['LBL_IMPORT_VCARD_BUTTON_LABEL'];
		echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], $params, true);
        $this->ss->display($this->getCustomFilePathIfExists('include/MVC/View/tpls/Importvcard.tpl'));
 	}
}
