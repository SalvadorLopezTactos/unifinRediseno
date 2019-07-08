
<?php
/**
 * The file used to handle survey re submission request  
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
if (!defined('sugarEntry') || !sugarEntry)
    define('sugarEntry', true);
include_once('config.php');
require_once('include/entryPoint.php');
require_once('data/SugarBean.php');
require_once('include/utils.php');
require_once('include/database/DBManager.php');
require_once('include/database/DBManagerFactory.php');
require_once('modules/Administration/Administration.php');

global $sugar_config, $db;

$encoded_param = $_REQUEST['q'];
$decoded_param = base64_decode($encoded_param);

$survey_id = substr($decoded_param, 0, 36);
$module_type_array = explode('=', substr($decoded_param, strpos($decoded_param, 'ctype='), 42));
$module_type_array = explode('&', $module_type_array[1]);
$module_type = $module_type_array[0];

$module_id_array = explode('=', substr($decoded_param, strpos($decoded_param, 'cid='), 40));
$module_id = $module_id_array[1];

$survey = new bc_survey();
$survey->retrieve($survey_id);

$default_survey_language = $survey->default_survey_language;

// get survey supported language
if (empty($_REQUEST['selected_lang'])) {
    $selected_lang = $default_survey_language;
} else if (isset($_REQUEST['selected_lang']) && !empty($_REQUEST['selected_lang'])) {
    $selected_lang = $_REQUEST['selected_lang'];
} else {
    $selected_lang = $sugar_config['default_language'];
}

// list of lang wise survey detail
$list_lang_detail_array = return_app_list_strings_language($selected_lang);
$list_lang_detail = $list_lang_detail_array[$survey_id];

$survey->load_relationship('bc_survey_pages_bc_survey');

require_once('include/SugarQuery/SugarQuery.php');
$oSubmissionList = $survey->get_linked_beans('bc_survey_submission_bc_survey', 'bc_survey_submission');
foreach ($oSubmissionList as $oSubmission) {
    if ($oSubmission->target_parent_id == $module_id && $oSubmission->target_parent_type == $module_type) {
        $submission_row['submission_id'] = $oSubmission->id;
        $submission_row['resubmit'] = $oSubmission->resubmit;
        $submission_row['resubmit_counter'] = $oSubmission->resubmit_counter;
        $submission_row['status'] = $oSubmission->status;
    }
}

$survey_submission = new bc_survey_submission();
$survey_submission->retrieve($submission_row['submission_id']);

$resubmit_request_success_msg = "Your request for re-submit ".ucfirst($survey->survey_type)." response is submitted successfully. You will be sent a confirmation email once admin approves your request.Thanks.";
if (!empty($list_lang_detail['resubmit_request_success_msg'])) {
    $resubmit_request_success_msg = $list_lang_detail['resubmit_request_success_msg'];
}

$resubmit_request_fail_msg = "Your request for re-submit ".ucfirst($survey->survey_type)." response is not submitted.";
if (!empty($list_lang_detail['resubmit_request_fail_msg'])) {
    $resubmit_request_fail_msg = $list_lang_detail['resubmit_request_fail_msg'];
}

$resubmit_request_already_sent_msg = "You have already requested for re-submit ".ucfirst($survey->survey_type)." response!";
if (!empty($list_lang_detail['resubmit_request_already_sent_msg'])) {
    $resubmit_request_already_sent_msg = $list_lang_detail['resubmit_request_already_sent_msg'];
}

if ($survey_submission->change_request == "Pending") {
    $msg1 = "<div class='failure_msg'>{$resubmit_request_already_sent_msg}</div>";
} else {
    $survey_submission->change_request = "Pending";
    if ($survey_submission->save()) {
        $msg1 = "<div class='success_msg' style='text-align:left !important;height:auto !important;top:25%;'>" . $resubmit_request_success_msg . "</div>";
    } else {
        $msg1 = "<div class='failure_msg'>{$resubmit_request_fail_msg}</div>";
    }
}

$themeObject = SugarThemeRegistry::current();
$favicon = $themeObject->getImageURL('sugar_icon.ico', false);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php if ($survey->survey_type == 'poll') { ?>
            <title>Poll</title>
        <?php } else { ?>
            <title>Survey</title>
        <?php } ?>

        <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon">
        <link href="<?php echo $sugar_config['site_url'] . '/custom/include/css/survey_css/survey-form.css' ?>" rel="stylesheet">
        <link href="<?php echo $sugar_config['site_url'] . '/custom/include/css/survey_css/' . $survey->survey_theme . '.css'; ?>" rel="stylesheet">
    </head>
    <body>
        <?php
        if ($survey->survey_theme == 'theme0') {
            // Set Sugar Header
            ?>
            <div id="sugarcrm">
                <div id="sidecar">
                    <div id="header">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="nav-collapse" style="padding:10px">

                                    <img src="custom/include/images/sugarcrm-color.png" alt="SugarCRM" height="26" width="150">

                                </div><!-- /navbar-inner -->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="bg"></div>
                    <div class="main-container">
                        <div id='tooltipDiv'></div>
                        <form method="post" name="survey_submisssion" action="" id="survey_submisssion">
                            <div class="top-section">
                                <div class="header">
                                    <div class="">
                                        <h1 class="logo">
                                            <?php
                                            if ($survey->id) {

                                                $sql = "SELECT image FROM bc_survey WHERE id='{$survey->id}'";

                                                // the result of the query
                                                $result = $db->query($sql);

                                                // set the header for the image
                                                while ($row = $db->fetchRow($result)) {
                                                    $base64 = base64_encode($row['image']);
                                                }
                                            }
                                            if (!empty($base64)) {
                                                ?>
                                                <img src="data:image/png;base64,<?php echo $base64; ?>" alt="" />
                                            <?php } ?>
                                        </h1>
                                        <div class="survey-header"><h2><?php echo html_entity_decode($survey->name); ?></h2></div>
                                    </div>
                                </div>
                            </div>
                            <div class="survey-container">
                                <?php
                                if (isset($msg1) && $msg1 != '') {
                                    echo "{$msg1}";
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                    <?php
                    if ($survey->survey_theme == 'theme0') {
                        // Set Sugar Header
                        ?>


                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </body>
</html>