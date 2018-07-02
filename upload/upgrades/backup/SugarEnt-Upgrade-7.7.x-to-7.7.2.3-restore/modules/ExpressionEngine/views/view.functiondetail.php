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
class ViewFunctiondetail extends SugarView
{
	function ViewFunctionDetail(){
		$this->options['show_footer'] = false;
		$this->options['show_header'] = false;
 		parent::SugarView();

 	}

 	function display(){
 		global $app_strings, $current_user, $mod_strings, $theme, $beanList, $beanFiles;
 		if (!is_file($cachefile = sugar_cached('Expressions/functionmap.php'))) {
        	$GLOBALS['updateSilent'] = true;
            include ('include/Expressions/updatecache.php');
        }
 		include $cachefile;
 		require_once('include/JSON.php');
 		$desc = "";
 		if (!empty($_REQUEST['function']) && !empty($FUNCTION_MAP[$_REQUEST['function']])){
 			$func_def =  $FUNCTION_MAP[$_REQUEST['function']];
			require_once($func_def['src']);
			$class = new ReflectionClass($func_def['class']);
			$doc = $class->getDocComment();
			if (!empty($doc)) {
				//Remove the javadoc style comment *'s
				$desc = preg_replace("/((\/\*+)|(\*+\/)|(\n\s*\*)[^\/])/", "", $doc);
			} else if (isset($mod_strings['func_descriptions'][$_REQUEST['function']]))
			{
				$desc = $mod_strings['func_descriptions'][$_REQUEST['function']];
			}
			else
			{
				$seed = $func_def['class'];
				$count = call_user_func(array($seed, "getParamCount"));
				$type = call_user_func(array($seed, "getParameterTypes"));
				$desc = $_REQUEST['function'] . "(";
				if ($count == -1)
				{
					$desc .=  $type . ", ...";
				} else {
					for ($i = 0; $i < $count; $i++) {
						if ($i != 0) $desc .= ", ";
						if (is_array($type))
							$desc .=  $type[$i] . ($i+1);
						else
							$desc .=  $type . ($i+1);
					}
				}
				$desc .= ")";
			}
		}
		else {
			$desc = "function not found";
		}
		echo json_encode(array(
			"func" => empty($_REQUEST['function']) ? "" : $_REQUEST['function'],
			"desc" => $desc,
		));
 	}
}
?>