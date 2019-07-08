<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class ViewHealth_check extends SugarView {

    function display() {

        require_once('modules/Administration/Administration.php');
        require_once 'custom/include/utilsfunction.php';

        echo "<script src='custom/include/js/survey_js/custom_code.js'></script>";

        $health_status = getHealthStatus();
        
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('SurveyPlugin');
        
        // check smtp status
        if(empty($health_status['smtp_status']))
        {
            $health_status['smtp_status'] = "SMTP Configuration Status is not available at this time.";
        }

        $html = '<style>.add_table img {vertical-align: bottom;}</style> <table id="health_status" border="0" cellpadding="0" cellspacing="0" width="800px">
                <tbody>
                <tr>
                    <td colspan="100">
                        <div class="moduleTitle">
                            <h2>Diagnostics Status</h2>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="100">
                        <div class="add_table" style="margin-bottom:5px">
                        <table  class="edit view" style="margin-bottom:0px;" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > License Configuration Status : </label></td>
                                <td nowrap="nowrap" style="width: 85%;height:30px;" id="license_status">'.$health_status['license_status'].'</td></tr>
                            <tr><td></td></tr><tr><td></td></tr>
                            
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > Scheduler Description : </label></td>
                                <td nowrap="nowrap" style="width: 85%;height:30px;" id="scheduler_desc">'.$health_status['scheduler_status']['send']['desc'].'</td></tr>
                                    <tr><td></td></tr><tr><td></td></tr>
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > Scheduler Status : </label></td>
                                <td nowrap="nowrap" style="width: 85%;height:30px;" id="scheduler_status">'.$health_status['scheduler_status']['send']['status'].'</td></tr>
                            
                            
                            <tr><td></td></tr><tr><td></td></tr>
                                
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > PHP Status : </label></td>
                                <td nowrap="nowrap" style="width: 85%;height:30px;" id="php_status">'.$health_status['php_status'].'</td></tr>
                            <tr><td></td></tr><tr><td></td></tr>
                                
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > Site URL Status : </label></td>
                                <td nowrap="nowrap" style="width: 85%;height:30px;" id="siteurl_status">'.$health_status['siteurl_status'].'</td></tr>
                            <tr><td></td></tr><tr><td></td></tr>
                                
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > SMTP Configuration Status : </label></td>
                                <td nowrap="nowrap" style="width: 85%;height:30px;" id="smtp_status">'.$health_status['smtp_status'].'</td></tr>
                            <tr><td></td></tr><tr><td></td></tr>
                            
                            <tr>
                                <td scope="row" nowrap="nowrap" style="width: 10%;"><label for="name_basic" > cURL Status : </label></td>
                                <td nowrap="nowrap" style="width: 85%; height:30px;" id="curl_status">'.$health_status['curl_status'].'</td></tr>

                         </tbody>
                         </table>  
                    </td>
                </tr>
                
                </tbody>
                </table>
                <br/>
                <input title="Back to Administrator" class="button primary back" onclick="javascript:parent.SUGAR.App.router.navigate(\'#bwc/index.php?module=Administration&action=index\', {trigger: true})"  name="back" value="Back to Administrator" type="button">';

        parent::display();
        echo $html;
    }

}
?>

