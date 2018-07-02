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




require_once('modules/ModuleBuilder/views/view.listview.php');

class ViewPortalListView extends ViewListView 
{
    public function __construct()
    {
        $this->editModule = $_REQUEST['view_module'];
        $this->editLayout = $_REQUEST['view'];
        $this->subpanel = (!empty($_REQUEST['subpanel'])) ? $_REQUEST['subpanel'] : false;
        $this->fromModuleBuilder = ! empty ( $_REQUEST [ 'view_package' ] ) ;
    }

    /**
	 * @see SugarView::_getModuleTitleParams()
	 */
	protected function _getModuleTitleParams($browserTitle = false)
	{
	    global $mod_strings;
	    
    	return array(
    	   translate('LBL_MODULE_NAME','Administration'),
    	   ModuleBuilderController::getModuleTitle(),
    	   );
    }

    function display() 
    {
        require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
        $parser = ParserFactory::getParser(MB_PORTALLISTVIEW,$this->editModule,null,null,MB_PORTAL);

        $smarty = $this->constructSmarty($parser);
        $smarty->assign('fromPortal',true); // flag for form submittal - when the layout is submitted the actions are the same for layouts and portal layouts, but the parsers must be different...
        $smarty->assign(
            'onsubmit',
            'studiotabs.generateGroupForm("edittabs"); if (countListFields()==0)' .
            '{ModuleBuilder.layoutValidation.popup();}else {ModuleBuilder.handleSave("edittabs");} return false;'
        );
        //Override the list view buttons to remove references to the history feature as the portal editors do not support it.
        $buttons = array ( 
            array ( 
                'id' =>'savebtn', 
                'name' => 'savebtn', 
                'text' => translate('LBL_BTN_SAVEPUBLISH'), 
                'type' => 'submit',
            )
        );
        $smarty->assign ( 'buttons', $this->_buildImageButtons ( $buttons ) ) ;
        
        
        $ajax = $this->constructAjax();
        $ajax->addSection('center', translate('LBL_EDIT_LAYOUT', 'ModuleBuilder'), $smarty->fetch("modules/ModuleBuilder/tpls/listView.tpl") );
        echo $ajax->getJavascript();

    }

    function constructAjax()
    {
        require_once('modules/ModuleBuilder/MB/AjaxCompose.php');
        $ajax = new AjaxCompose();

		$ajax->addCrumb(translate('LBL_SUGARPORTAL', 'ModuleBuilder'), 'ModuleBuilder.main("sugarportal")');
        $ajax->addCrumb(translate('LBL_LAYOUTS', 'ModuleBuilder'), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&portal=1&layout=1")');
  		$ajax->addCrumb(ucwords(translate('LBL_MODULE_NAME',$this->editModule)), 'ModuleBuilder.getContent("module=ModuleBuilder&action=wizard&portal=1&view_module='.$this->editModule.'")');
		$ajax->addCrumb(ucwords($this->editLayout), '');

        return $ajax;
    }
}
