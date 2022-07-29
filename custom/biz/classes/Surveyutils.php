<?php

/**
 * The file used to manage actions for validating license 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
require_once('modules/Administration/Administration.php');

class Surveyutils {

    /**
     * Description :: This function is used to check validation status of license for Survey Rocket.
     * 
     * @param $licensekey - license key to validate
     * @return bool      0 - license not validated
     *                   1 - license validated
     *         string    $result - license status message
     */
    public static function checkPluginLicense($licenseKey) {
        global $sugar_config,$timedate;
        $oAdministration = new Administration();
        $oAdministration->retrieveSettings('SurveyPlugin');

        $domain = $sugar_config['site_url'];
        $pluginSku = $oAdministration->settings['SurveyPlugin_SurveyProductSKU'];
        $moduleEnabled = $oAdministration->settings['SurveyPlugin_ModuleEnabled'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('https://www.appjetty.com/extension/licence.php'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'key=' . urlencode($licenseKey) . '&domains=' . urlencode($domain) . '&sec=' . $pluginSku);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $content = curl_exec($ch);
        $result = json_decode($content);
        $errmsg = curl_error($ch);
        $errNo = curl_errno($ch);

        $expired_date = $timedate->to_display_date_time($result->expiray_date, true, true, $current_user);
        $actual_expired_date = explode(" ", $expired_date);
        $result->expiray_date = $actual_expired_date[0];
        
        $LicenseFrequency = $oAdministration->settings['SurveyPlugin_LicenseFrequency'];
        $currDate = date("Y/m/d");
        $nextValidationDate = date('Y/m/d', strtotime("+{$LicenseFrequency} days"));
        if ($result->suc == 1) {
            // get configuration for license status
            $oAdministration->saveSetting("SurveyPlugin", "LicenseKey", $licenseKey);
            $oAdministration->saveSetting("SurveyPlugin", "LastValidation", 1);
            $oAdministration->saveSetting("SurveyPlugin", "LastValidationDate", $currDate);
            $oAdministration->saveSetting("SurveyPlugin", "NextValidationDate", $nextValidationDate);
            if (empty($oAdministration->settings['SurveyPlugin_LicenseKey'])) { // key is not provided
                $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
                $oAdministration->saveSetting("SurveyPlugin", "ModuleEnabled", 0);
            } else if ($result->warning == 1) {
                $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", $result->msg);
                if (!$moduleEnabled || $moduleEnabled == 0) {
                $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
            } else {
                    $administrationObj->saveSetting("SurveyPlugin", "LastValidationMsg", '');
                }
            } else {
                if (!$moduleEnabled || $moduleEnabled == 0) {
                    $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
                } else {
                $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", '');
            }
            }
        } else {
            $oAdministration->saveSetting("SurveyPlugin", "LicenseKey", "");
            $oAdministration->saveSetting("SurveyPlugin", "LastValidation", 0);
            $oAdministration->saveSetting("SurveyPlugin", "LastValidationDate", $currDate);
            $oAdministration->saveSetting("SurveyPlugin", "NextValidationDate", '');
            if ($errNo > 0) { //license key invalid
                $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", 'There seems some error while validating your license for Survey Rocket Package. Please try again later.<br /><b>Error : ' . $errmsg . '</b>');
            } else {
                $oAdministration->saveSetting("SurveyPlugin", "LastValidationMsg", $result->msg);
            }
            $oAdministration->saveSetting("SurveyPlugin", "ModuleEnabled", 0);
        }
        return $result;
    }

    /**
     * Description :: This function is used to validate Survey Rocket License.
     * 
     * @param $licensekey - license key to validate 
     * @return array $response      success - false - license not validated
     *                                        true - license validated
     *                              message - license status message
     */
    public static function validateSurveySubscription() {
        global $app_strings;
        //check license is validated or not
        $oAdministration = new Administration();
        $oAdministration->retrieveSettings('SurveyPlugin');

        $lastValidation = $oAdministration->settings['SurveyPlugin_LastValidation'];
        $lastValidationMsg = $oAdministration->settings['SurveyPlugin_LastValidationMsg'];
        $moduleEnabled = $oAdministration->settings['SurveyPlugin_ModuleEnabled'];
        $currDate = strtotime(date("Y/m/d"));
        $nextValidationDate = strtotime($oAdministration->settings['SurveyPlugin_NextValidationDate']);
        $licenseKey = $oAdministration->settings['SurveyPlugin_LicenseKey'];

        $response = array();
        if ($licenseKey && $lastValidation && $nextValidationDate) {
            if ($currDate >= $nextValidationDate) {
                $checkResult = self::checkPluginLicense($licenseKey);
                if ($checkResult) {
                    if ($moduleEnabled == 1) {// license validated and plugin is enabled
                        $response['success'] = true;
                        $response['message'] = html_entity_decode($lastValidationMsg);
                    } else {
                        $response['success'] = false;
                        $response['message'] = html_entity_decode($lastValidationMsg);
                    }
                } else {
                    return array('success' => 0, 'message' => $app_strings['VALIDATE_ERROR']);
                }
            } else {
                if (($lastValidation == 1) && ($moduleEnabled == 1)) {
                    $response['success'] = true;
                    $response['message'] = html_entity_decode($lastValidationMsg);
                } else { // license not validated or plugin is disabled
                    $response['success'] = false;
                    $response['message'] = html_entity_decode($lastValidationMsg);
                }
            }
        } else {
            return array('success' => 0, 'message' => $app_strings['VALIDATE_FAIL']);
        }
        return $response;
    }

}
