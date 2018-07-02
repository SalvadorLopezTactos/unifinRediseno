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

require_once 'include/MVC/View/views/view.edit.php';

class PdfManagerViewEdit extends ViewEdit
{
    /**
     * @deprecated Use __construct() instead
     */
    public function PdfManagerViewEdit($bean = null, $view_object_map = array(), Request $request = null)
    {
        self::__construct($bean, $view_object_map, $request);
    }

    public function __construct($bean = null, $view_object_map = array(), Request $request = null)
    {
        parent::__construct($bean, $view_object_map, $request);
    }

    public function display()
    {
    
        // Disable VCR Control
        $this->ev->showVCRControl = false;

        // Default Team as Global
        if ((empty($this->bean->id))  && !$this->ev->isDuplicate) {
            $this->bean->team_id = 1;
            $this->bean->team_set_id = 1;
        }
    
        // Load TinyMCE
        require_once 'include/SugarTinyMCE.php';
        $tiny = new SugarTinyMCE();
        $tiny->defaultConfig['apply_source_formatting']=true;
        $tiny->defaultConfig['cleanup_on_startup']=true;
        $tiny->defaultConfig['relative_urls']=false;
        $tiny->defaultConfig['convert_urls']=false;
        $ed = $tiny->getInstance('body_html');
        $this->ss->assign('tiny_script', $ed);

        // Load Fields for main module
        if (empty($this->bean->base_module)) {
            $modulesList = PdfManagerHelper::getAvailableModules();
            $this->bean->base_module = key($modulesList);
        }
        $fieldsForSelectedModule = PdfManagerHelper::getFields($this->bean->base_module, true);

        $this->ss->assign('fieldsForSelectedModule', $fieldsForSelectedModule);

        parent::display();
    }
}
