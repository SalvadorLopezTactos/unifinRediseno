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

 * Description:  Contains a variety of utility functions used to display UI
 * components such as form headers and footers.  Intended to be modified on a per
 * theme basis.
 ********************************************************************************/

/**
 * Create javascript to validate the data entered into a record.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_validate_record_js () {
	global $app_strings;
	global $current_language;
	
	$mod_strings = return_module_language($current_language, 'ForecastSchedule');

	$lbl_start_date = $mod_strings['LBL_FC_START_DATE'];
	$lbl_user = $mod_strings['LBL_FC_USER'];
	$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];

$the_script  = <<<EOQ

	<script type="text/javascript" language="Javascript">
	<!--  to hide script contents from old browsers

	function verify_data(form) {
		var isError = false;
		var errorMessage = "";
		if (trim(form.forecast_start_date.value) == "") {
			isError = true;
			errorMessage += "\\n$lbl_start_date";
		}
		if (trim(form.user_id.value) == "") {
			isError = true;
			errorMessage += "\\n$lbl_user";
		}
		if (isError == true) {
			alert("$err_missing_required_fields" + errorMessage);
			return false;
		}
		return true;
	}
	// end hiding contents from old browsers  -->
	</script>
EOQ;

	return $the_script;
}
?>