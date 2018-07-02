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

require_once('include/MVC/View/views/view.detail.php');

class EmployeesViewDetail extends ViewDetail {

 	function EmployeesViewDetail(){
 		parent::ViewDetail();
 	}
 	
   /**
    * Return the "breadcrumbs" to display at the top of the page
    *
    * @param  bool $show_help optional, true if we show the help links
    * @return HTML string containing breadcrumb title
    */
    public function getModuleTitle($show_help = true)
    {
        global $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $action, $current_user;

        $theTitle = "<div class='moduleTitle'>\n";

        $module = preg_replace("/ /","",$this->module);

        $params = $this->_getModuleTitleParams();
        $count = count($params);
        $index = 0;

		if(SugarThemeRegistry::current()->directionality == "rtl") {
			$params = array_reverse($params);
		}

        $paramString = '';
        foreach($params as $parm){
            $index++;
            $paramString .= $parm;
            if($index < $count){
                $paramString .= $this->getBreadCrumbSymbol();
            }
        }

        if(!empty($paramString)){
            $theTitle .= "<h2> $paramString </h2>\n";
        }

        if ($show_help) {
            $theTitle .= "<span class='utils'>";
            if(is_admin($current_user) || is_admin_for_module($current_user, $this->module))
            {
            $createImageURL = SugarThemeRegistry::current()->getImageURL('create-record.gif');
            $theTitle .= <<<EOHTML
&nbsp;
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
<img src='{$createImageURL}' alt='{$GLOBALS['app_strings']['LNK_CREATE']}'></a>
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
{$GLOBALS['app_strings']['LNK_CREATE']}
</a>
EOHTML;
            }
        }

        $theTitle .= "</span></div>\n";
        return $theTitle;
    }

 	function display() {
       	if(is_admin($GLOBALS['current_user']) || $_REQUEST['record'] == $GLOBALS['current_user']->id) {
			 $this->ss->assign('DISPLAY_EDIT', true);
        }
        if(is_admin($GLOBALS['current_user'])){
 			$this->ss->assign('DISPLAY_DUPLICATE', true);
 		}

 		$showDeleteButton = FALSE;
 		if(  $_REQUEST['record'] != $GLOBALS['current_user']->id && $GLOBALS['current_user']->isAdminForModule('Users') )
        {
            $showDeleteButton = TRUE;
 		     if( empty($this->bean->user_name) ) //Indicates just employee
 		         $deleteWarning = $GLOBALS['mod_strings']['LBL_DELETE_EMPLOYEE_CONFIRM'];
 		     else
 		         $deleteWarning = $GLOBALS['mod_strings']['LBL_DELETE_USER_CONFIRM'];
 		     $this->ss->assign('DELETE_WARNING', $deleteWarning);
        }
        $this->ss->assign('DISPLAY_DELETE', $showDeleteButton);
        
 		parent::display();
 	}
}
?>
