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

/*********************************************************************************
* Description:
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
* Reserved. Contributor(s): contact@synolia.com - www.synolia.com
* *******************************************************************************/

require_once('include/connectors/formatters/default/formatter.php');

class ext_rest_dnb_formatter extends default_formatter {
	
public function getDetailViewFormat() { 
   $mapping = $this->getSourceMapping();
   $mapping_name = !empty($mapping['beans'][$this->_module]['name']) ? $mapping['beans'][$this->_module]['name'] : '';

   if(!empty($mapping_name)) {
	   $this->_ss->assign('mapping_name', $mapping_name);
	   return $this->fetchSmarty();
   }

   $GLOBALS['log']->error($GLOBALS['app_strings']['ERR_MISSING_MAPPING_ENTRY_FORM_MODULE']);
   return '';
}	

public function getIconFilePath() {
   return 'modules/Connectors/connectors/formatters/ext/rest/dnb/dnb.jpg';
}   

}
?>
