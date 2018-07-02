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
require_once('include/MVC/View/SugarView.php');
require_once('include/Sugarpdf/FontManager.php');
class ConfiguratorViewAddFontView extends SugarView {
   
    /**
     * Constructor
     */
    public function AddFontView(){
        parent::SugarView();
    }
    /** 
     * display the form
     */
    public function display(){
        global $mod_strings, $app_list_strings, $app_strings, $current_user;
        if(!is_admin($current_user)){
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);  
        }

        // create FontManager to load sugarpdf_config
        $fontManager = new FontManager();

        $this->ss->assign("MODULE_TITLE", 
            getClassicModuleTitle(
                $mod_strings['LBL_MODULE_ID'], 
                array($mod_strings['LBL_ADDFONT_TITLE']), 
                true
                )
            );
        if(!empty($_REQUEST['error'])){
            $this->ss->assign("error", $_REQUEST['error']);
        }
        $this->ss->assign("MOD", $mod_strings);
        $this->ss->assign("APP", $app_strings);
        if(isset($_REQUEST['return_action'])){
            $this->ss->assign("RETURN_ACTION", $_REQUEST['return_action']);
        }else{
            $this->ss->assign("RETURN_ACTION", 'FontManager');
        }
        $this->ss->assign("STYLE_LIST", array(
                "regular"=>$mod_strings["LBL_FONT_REGULAR"],
                "italic"=>$mod_strings["LBL_FONT_ITALIC"],
                "bold"=>$mod_strings["LBL_FONT_BOLD"],
                "boldItalic"=>$mod_strings["LBL_FONT_BOLDITALIC"]
         ));
         $this->ss->assign("ENCODING_TABLE", array_combine(explode(",",PDF_ENCODING_TABLE_LIST), explode(",",PDF_ENCODING_TABLE_LABEL_LIST)));
        
//display
        $this->ss->display('modules/Configurator/tpls/addFontView.tpl');
    }
}

