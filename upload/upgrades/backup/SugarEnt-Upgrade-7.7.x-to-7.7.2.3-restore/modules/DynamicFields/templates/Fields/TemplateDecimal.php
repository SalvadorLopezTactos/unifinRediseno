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

class TemplateDecimal extends TemplateFloat{
	var $type = 'decimal';
	var $default = null;
	var $default_value = null;
	
	function TemplateDecimal(){
    	parent::__construct();
	}

    function get_db_type()
	{
		if(empty($this->len)) {
			return parent::get_db_type();
		}
		$precision = (!empty($this->precision)) ? $this->precision : 6;
		return " ".sprintf($GLOBALS['db']->getColumnType("decimal_tpl"), $this->len, $precision); 
	}
}

?>
