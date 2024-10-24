<?php
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

class ViewDisplaydeployresult extends SugarView
{
    /**
     * @var bool
     */
    public $show_header;
    /**
     * @var bool
     */
    public $show_title;
    /**
     * @var bool
     */
    public $show_subpanels;
    /**
     * @var bool
     */
    public $show_search;
    /**
     * @var bool
     */
    public $show_javascript;
    /**
     * @var bool
     */
    public $view_print;

    public function __construct()
    {
        $this->show_header = false;
        $this->show_title = false;
        $this->show_subpanels = false;
        $this->show_search = false;
        $this->show_javascript = true;
        $this->view_print = false;
    }

    /**
     * @see SugarView::_getModuleTitleParams()
     */
    // @codingStandardsIgnoreLine PSR2.Methods.MethodDeclaration.Underscore
    protected function _getModuleTitleParams($browserTitle = false)
    {
        global $mod_strings;

        return [
            translate('LBL_MODULE_NAME', 'Administration'),
            ModuleBuilderController::getModuleTitle(),
        ];
    }

    public function display()
    {
        $message = $this->view_object_map['message'];
        echo $message . getVersionedScript('cache/include/javascript/sugar_grp1_yui.js?') . "<script type='text/javascript' language='Javascript'>YAHOO.util.Connect.asyncRequest('GET', 'index.php?module=Administration&action=RebuildRelationship&silent=true');</script>";
    }
}
