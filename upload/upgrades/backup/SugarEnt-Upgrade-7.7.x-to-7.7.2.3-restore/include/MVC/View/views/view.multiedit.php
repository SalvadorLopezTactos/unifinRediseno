<?php

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

require_once('include/EditView/EditView2.php');
 class ViewMultiedit extends SugarView{
 	var $type ='edit';
 	function ViewMultiedit(){
 		parent::SugarView();
 	}
 	
 	function display(){
		global $beanList, $beanFiles;
		if($this->action == 'AjaxFormSave'){
			echo "<a href='index.php?action=DetailView&module=".$this->module."&record=".$this->bean->id."'>".$this->bean->id."</a>";
		}else{
			if(!empty($_REQUEST['modules'])){
				$js_array = 'Array(';
				
				$count = count($_REQUEST['modules']);
				$index = 1;
				foreach($_REQUEST['modules'] as $module){
					$js_array .= "'form_".$module."'";
					if($index < $count)
						$js_array .= ',';
					$index++;
				}
				//$js_array = "Array(".implode(",", $js_array). ")";
				$js_array .= ');';
				echo "<script language='javascript'>var ajaxFormArray = new ".$js_array."</script>";
				if($count > 1)
					echo '<input type="button" class="button" value="Save All" id=\'ajaxsaveall\' onclick="return saveForms(\'Saving...\', \'Save Complete\');"/>';
				foreach($_REQUEST['modules'] as $module){
					$bean = $beanList[$module];
					require_once($beanFiles[$bean]);
					$GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $module);
					$ev = new EditView($module);
					$ev->process();
					echo "<div id='multiedit_form_".$module."'>";
					echo $ev->display(true, true);
					echo "</div>";
				}
			}
		}
 	}
 }
