<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

// FIXME will we need this file to update the modules that are sidecar enabled?
//class ViewConfigureAjaxUI extends SugarView
//{
//    /**
//     * @see SugarView::_getModuleTitleParams()
//     */
//    protected function _getModuleTitleParams($browserTitle = false)
//    {
//        return array(
//            "<a href='index.php?module=Administration&action=index'>" . translate('LBL_MODULE_NAME') . "</a>",
//            translate('LBL_CONFIG_AJAX')
//        );
//    }
//
//    /**
//     * @see SugarView::preDisplay()
//     */
//    public function preDisplay()
//    {
//        global $current_user;
//
//        if (!is_admin($current_user))
//        {
//            sugar_die("Unauthorized access to administration.");
//        }
//    }
//
//    /**
//     * @see SugarView::display()
//     */
//    public function display()
//    {
//        global $sugar_config, $moduleList;
//        //create array of subpanels to show, used to create Drag and Drop widget
//        $enabled = array();
//        $disabled = array();
//        $banned = ajaxBannedModules();
//
//        foreach($moduleList as $module)
//        {
//            if (!in_array($module, $banned))
//            {
//                $enabled[] = array("module" => $module, 'label' => translate($module));
//            }
//        }
//        if (!empty($sugar_config['addAjaxBannedModules']))
//        {
//            foreach( $sugar_config['addAjaxBannedModules'] as $module)
//            {
//                $disabled[] = array("module" => $module, 'label' => translate($module));
//            }
//        }
//
//        $this->ss->assign('enabled_mods', json_encode($enabled));
//        $this->ss->assign('disabled_mods', json_encode($disabled));
//        $this->ss->assign('title',$this->getModuleTitle(false));
//
//        echo $this->ss->fetch('modules/Administration/templates/ConfigureAjaxUI.tpl');
//    }
//}
