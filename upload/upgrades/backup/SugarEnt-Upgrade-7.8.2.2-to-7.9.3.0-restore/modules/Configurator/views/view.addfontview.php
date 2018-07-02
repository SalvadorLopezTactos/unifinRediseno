<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Sugarcrm\Sugarcrm\Security\InputValidation\Request;

require_once('include/MVC/View/SugarView.php');
require_once('include/Sugarpdf/FontManager.php');
class ConfiguratorViewAddFontView extends SugarView {

    /**
     * @deprecated Use __construct() instead
     */
    public function AddFontView($bean = null, $view_object_map = array(), Request $request = null)
    {
        self::__construct($bean, $view_object_map, $request);
    }

    public function __construct($bean = null, $view_object_map = array(), Request $request = null)
    {
        parent::__construct($bean, $view_object_map, $request);
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
        $this->ss->assign("error", $this->request->getValidInputRequest('request_error'));
        $this->ss->assign("MOD", $mod_strings);
        $this->ss->assign("APP", $app_strings);
        $return_action = $this->request->getValidInputRequest('return_action', null, 'FontManager');
        $this->ss->assign("RETURN_ACTION", $return_action);
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
