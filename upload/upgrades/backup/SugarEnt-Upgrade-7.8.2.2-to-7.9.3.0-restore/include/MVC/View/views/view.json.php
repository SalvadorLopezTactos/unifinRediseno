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

use Sugarcrm\Sugarcrm\Security\InputValidation\Request;

class ViewJson extends SugarView{
	var $type ='detail';

    /**
     * @deprecated Use __construct() instead
     */
    public function ViewJson($bean = null, $view_object_map = array(), Request $request = null)
    {
        self::__construct($bean, $view_object_map, $request);
    }

    public function __construct($bean = null, $view_object_map = array(), Request $request = null)
    {
        parent::__construct($bean, $view_object_map, $request);
    }

	function display(){
 		global $beanList;
		$module = $GLOBALS['module'];
		$json = getJSONobj();
		$bean = $this->bean;
		$all_fields = array_merge($bean->column_fields,$bean->additional_column_fields);
		
		$js_fields_arr = array();
		foreach($all_fields as $field) {
			if(isset($bean->$field)) {
				$bean->$field = from_html($bean->$field);
				$bean->$field = preg_replace('/\r\n/','<BR>',$bean->$field);
				$bean->$field = preg_replace('/\n/','<BR>',$bean->$field);
				$js_fields_arr[$field] = addslashes($bean->$field);
			}
		}
		$out = $json->encode($js_fields_arr, true);
		ob_clean();
		print($out);
		sugar_cleanup(true);
	}
}
