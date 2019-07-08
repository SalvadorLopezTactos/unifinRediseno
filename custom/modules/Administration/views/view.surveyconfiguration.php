<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

/**
 * The file used for displaying license View for Survey Rocket
 * which includes validation of license key and enable/disable plugin.
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
class ViewSurveyConfiguration extends SugarView {

    function display() {
        global $sugar_version;
        require_once('modules/Administration/Administration.php');
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('SurveyPlugin');
        $LastValidation = $administrationObj->settings['SurveyPlugin_LastValidation'];
        $ModuleEnabled = $administrationObj->settings['SurveyPlugin_ModuleEnabled'];

        $licenseKey = (!empty($administrationObj->settings['SurveyPlugin_LicenseKey'])) ? $administrationObj->settings['SurveyPlugin_LicenseKey'] : "";


        $html = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr><td colspan="100"><h2><div class="moduleTitle">
                <h2>License Configuration </h2>
                <div class="clear"></div></div>
                </h2></td></tr>
                <tr><td colspan="100">
	            <div class="add_table" style="margin-bottom:5px">
		        <table id="ConfigureSurvey" class="themeSettings edit view" style="margin-bottom:0px;" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			    <tr><th align="left" colspan="4" scope="row"><h4>Validate License</h4></th></tr>
			    <tr>
			    <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic"> License Key : </label></td>';
        $hidden = "";
        if ($LastValidation == 1) {
            $hidden = "display:none";
            $html .= '	<td nowrap="nowrap" style="width: 15%;"><input name="license_key" id="license_key" size="30" maxlength="255" value="' . $licenseKey . '" title="" accesskey="9" type="text" readonly></td>
            	<td nowrap="nowrap" style="width: 20%;"><input title="Validate" id="Validate" class="button primary" onclick="validateLicense(this);" name="validate" value="Validate" type="button">&nbsp;<input title="Clear" id="clearkey" class="button primary" onclick="clearKey();" name="clear" value="Clear" type="button" style="' . $hidden . '"><span style="color:green;padding-left: 10px;" id="error_span_succ">License validated successfully.</span></td>';
        } else if ($LastValidation == 0) {
            $html .= '	<td nowrap="nowrap" style="width: 15%;"><input name="license_key" id="license_key" size="30" maxlength="255" value="' . $licenseKey . '" title="" accesskey="9" type="text"></td>
            	<td nowrap="nowrap" style="width: 20%;"><input title="Validate" id="Validate" class="button primary" onclick="validateLicense(this);" name="validate" value="Validate" type="button">&nbsp;<input title="Clear" id="clearkey" class="button primary" onclick="clearKey();" name="clear" value="Clear" type="button"></td>';
        }
        $html .= '<td nowrap="nowrap" style="width: 55%;">&nbsp;</td>
            	</tr></tbody></table></div>';
        $display_enable = "display:none;";
        $display_validate = "display:block;";
        if ($LastValidation == 1) {
            $display_enable = "display:block;";
            $display_validate = "display:none;";
        }
        $html .= '<table class="actionsContainer" style="' . $display_validate . '" border="0" cellpadding="1" cellspacing="1">
		        <tbody><tr><td>
				<input title="Back" accesskey="l" class="button" onclick="redirectToindex();" name="button" value="Back" type="button">
			    </td></tr>
            	</tbody></table>
                </td></tr></tbody></table>';
        //    Enable/Disable Plugin Section
        $html .= '<div class="add_table" id="enableDiv" style="margin-bottom:5px;' . $display_enable . '">
		        <table id="ConfigureSurvey" class="themeSettings edit view" style="margin-bottom:0px;" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			    <tr><th align="left" colspan="4" scope="row"><h4>Enable/Disable Module</h4></th></tr>
                <tr>
			    <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic"> Enable/Disable </label></td>
            	<td nowrap="nowrap" style="width: 15%;">
            	<select name="enable" id="enable">';
        if ($ModuleEnabled == "1") {
            $html .= '<option value="1" selected="">Enable</option>
            	     <option value="0">Disable</option>';
        } else {
            $html .= '<option value="1">Enable</option>
            	     <option value="0" selected="">Disable</option>';
        }
        $html .= '</select>
            	</td>
            	<td nowrap="nowrap" style="width: 20%;">&nbsp;</td>
            	<td nowrap="nowrap" style="width: 55%;">&nbsp;</td>
            	</tr>
                </tbody></table>
	            </div>
	            <table class="actionsContainerEnableDiv" style="' . $display_enable . '" border="0" cellpadding="1" cellspacing="1">
		        <tbody><tr><td>
				<input title="Save" accesskey="a" class="button primary" onclick="enableSurveyPlugin();" name="button" value="Save" type="submit">
				<input title="Cancel" accesskey="l" class="button" onclick="redirectToindex();" name="button" value="Cancel" type="button">
			    </td></tr>
            	</tbody></table>
                </td></tr></tbody></table>';

        $html .= '<script type="text/javascript">
                    $("document").ready(function(){
                    $("#error_span").remove();
                    if($("#license_key").val() != ""){
                        $("#Validate").trigger("click");   // On page load validate license for checking license expiry details.
                    }
                    })
                    function clearKey(){
                        $("#license_key").val("");
                        $("#error_span").html("");
                    }
                    function redirectToindex(){
                        location.href = "index.php?module=Administration&action=index";
                    }
                   function validateLicense(element){
                    $("#error_span").remove();
                    $("#error_span_succ").hide();
                    var key = $("#license_key");
                    var trimKeyVal = key.val().trim();
                        if(key.val().trim() == ""){
                            $("#clearkey").after("<span style=\'color:red;padding-left: 10px;\' id=\'error_span\'>Please enter valid license key.</span>")
                            key.focus();
                            $("#enableDiv").hide();
                            $("#error_span_succ").hide();
                            return false;
                        }else{
                                    $("#clearkey").after("<img style=\'color:red;padding-left: 10px;vertical-align: middle;\' id=\'survey_loader\' src= "+SUGAR.themes.loading_image+">");
                                    $(element).attr("disabled","disabled");
                            
                            var url = app.api.buildURL("bc_survey", "validateLicense", "", {k: trimKeyVal});
                            app.api.call("GET", url, {}, {
                            
                                success:function(result){
                                if(typeof result != "object"){
                                    result = $.parseJSON(result);
                                }
                                // Count Expiry datatime
                                var current_datetime = new Date().getTime();
                                var expired_datetime = new Date(result.expiray_date).getTime();
                                
                                 $("#error_span_succ").hide();
                                $("#survey_loader").remove();
                                $("#enSelect option[value=0]").prop("selected", true);
                                        if(result[\'suc\'] == 1){
                                            $("#enableDiv").show();
                                            $(".actionsContainerEnableDiv").show();
                                            $(".actionsContainer").hide();
                                            $("#license_key").prop("readonly", true);
                                            $("#clearkey").after("<span style=\'color:green;padding-left: 10px;\' id=\'error_span\'>License validated successfully.</span>");
                                            $("#clearkey").hide();
                                            $("#license_key").val(trimKeyVal);
                                            /*  Start : Add By SP  29 Sep 2018
                                            *  Add license expiry details.
                                            */
                                            var expired_msg = "";
                                            if (result.trial_flag == "0") {
                                                expired_msg = "<span style=\'color:green;padding-left: 10px;\' id=\'license_expired\'>Your subscription will complete on " + result.expiray_date + "</span></div>";
                                            } else {
                                                var timeDiff = Math.abs(expired_datetime - current_datetime);
                                                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                                                expired_msg = "<span style=\'color:red;padding-left: 10px;\' id=\'license_expired\'>Your trial will be expire after " + diffDays + " days.</span>";
                                            }
                                            if ($("#license_expired").length == 0) {
                                                 $("#error_span").append(expired_msg);
                                            } else {
                                                 $("#license_expired").html(expired_msg);
                                            }
                                            // End
                                            
                                        }else{
                                            if(!result["msg"])
                                            {
                                                result["msg"] = "There seems some error while validating your license!";
                                            }
                                            $("#clearkey").after("<span style=\'color:red;padding-left: 10px;\' id=\'error_span\'>"+result[\'msg\']+"</span>");
                                            $("#enableDiv").hide();
                                            $(".actionsContainerEnableDiv").hide();
                                            $(".actionsContainer").show();
                                            $("#license_key").removeAttr("readonly");
                                            $("#clearkey").show();
                                            /*  Start : Add By SP  29 Sep 2018
                                            *  Add license expiry details.
                                            */
                                            if (expired_datetime < current_datetime) {
                                                expired_msg = "<span style=\'color:red;padding-left: 10px;\' id=\'license_expired\'> Your License key was expire on " + result.expiray_date + "</span>";
                                                if ($("#license_expired").length == 0) {
                                                     $("#error_span").append(expired_msg);
                                                } else {
                                                      $("#license_expired").html(expired_msg);
                                                }
                                            }
                                            // End
                                        }
                                    },
                                    complete : function(){
                                    $("#survey_loader").remove();
                                    $(element).removeAttr("disabled");
                                },
                                });
                            }
                        }
                    function enableSurveyPlugin(){
                        var license_key = $("#license_key").val();
                        if(license_key && license_key.trim())
                        {
                            var enabled = $("#enable").val();
                            var url = app.api.buildURL("bc_survey", "enableDisableSurvey", "", {enabled: enabled});
                            app.api.call("GET", url, {}, {
                                success:function(result){
                                    if(enabled == "1"){
                                    alert("Module enabled successfully.");
                                    }else{
                                    alert("Module disabled successfully.");
                                    }
                                    location.href = "index.php?module=Administration&action=index";
                                  }
                                });
                        }else{
                                alert("Please enter valid license key.");
                                return false;
                        }
                    }
                  </script>';
        parent::display();
        echo $html;
    }

}
