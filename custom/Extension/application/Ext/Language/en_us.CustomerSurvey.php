<?php

/**
 * The file used to store Survey Related Language Label & Options 
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
global $app_list_strings;


$app_list_strings['moduleList']['bc_survey_questions'] = 'Survey Questions';
$app_list_strings['moduleList']['bc_survey_answers'] = 'Survey Answers';
$app_list_strings['moduleList']['bc_survey_template'] = 'Survey Templates';
$app_list_strings['moduleList']['bc_survey'] = 'Surveys';
$app_list_strings['moduleList']['bc_survey_pages'] = 'Survey Pages';
$app_list_strings['moduleList']['bc_survey_submission'] = 'Survey Transactions';
$app_list_strings['moduleList']['bc_submission_data'] = 'Submission Data';


$app_list_strings['question_type_list']['Textbox'] = 'Textbox';
$app_list_strings['question_type_list']['CommentTextbox'] = 'Comment Textbox';
$app_list_strings['question_type_list']['Checkbox'] = 'Checkbox';
$app_list_strings['question_type_list']['RadioButton'] = 'Radio Button';
$app_list_strings['question_type_list']['DrodownList'] = 'DropdownList';
$app_list_strings['question_type_list']['MultiSelectList'] = 'MultiSelectList';
$app_list_strings['question_type_list']['ContactInformation'] = 'ContactInformation';
$app_list_strings['parent_type_list'][''] = '';
$app_list_strings['parent_type_list']['Survey'] = 'Survey';
$app_list_strings['parent_type_list']['SurveyTemplate'] = 'Survey Template';
$app_list_strings['survey_submission_list']['Pending'] = 'Submission Pending';
$app_list_strings['survey_submission_list']['Submitted'] = 'Submitted';
$app_list_strings['theme_list'] = array(
    'theme0' => 'Sugar Default',
    'theme1' => 'Innovative',
    'theme2' => 'Ultimate',
    'theme3' => 'Incredible',
    'theme4' => 'Agile',
    'theme5' => 'Contemporary',
    'theme6' => 'Creative',
    'theme7' => 'Professional',
    'theme8' => 'Elegant',
    'theme9' => 'Automated',
    'theme10' => 'Exclusive',
);

$app_strings['VALIDATE_ERROR'] = 'There seems some error while validating your license for Survey Rocket Plugin. Please try again later.';
$app_strings['VALIDATE_FAIL'] = 'Please contact your Administrator to validate License.';

$app_list_strings['submitted_by'] = array(
    'receipient' => 'Receipient',
    'sender' => 'Sender',
);

//Survey Automation List
$app_list_strings['execution_occurs_list'] = array(
    'when_record_saved' => 'When record saved',
    'when_survey_scheduler_executes' => 'When survey scheduler executes',
);

$app_list_strings['automation_status_list'] = array(
    'active' => 'Active',
    'inactive' => 'Inactive',
);

$app_list_strings['applied_to_list'] = array(
    'new_and_updated_records' => 'New and Updated records',
    'new_records_only' => 'New records only',
    'updated_records_only' => 'Updated records only'
);

$app_list_strings['filter_by']['all_related'] = 'All Related';
$app_list_strings['filter_by']['any_related'] = 'Any Related';

$app_list_strings['operator_list'] = array(
    'Equal_To' => 'Equals to',
    'Not_Equal_To' => 'Not Equals to',
    'is_null' => 'Is null',
    'Greater_Than' => 'Greater Than',
    'Less_Than' => 'Less Than',
    'Greater_Than_or_Equal_To' => 'Greater Than or Equal To',
    'Less_Than_or_Equal_To' => 'Less Than or Equal To',
    'Contains' => 'Contains',
    'Starts_With' => 'Starts With',
    'Ends_With' => 'Ends With',
    'Any_Change' => 'Any Change'
);


$app_list_strings['value_type_list']['Value'] = 'Value';
$app_list_strings['value_type_list']['Field'] = 'Field';
$app_list_strings['value_type_list']['SecurityGroup'] = 'In SecurityGroup';
$app_list_strings['value_type_list']['Date'] = 'Date';
$app_list_strings['value_type_list']['Multi'] = 'One of';

//Survey Automation Actions Fields
$app_list_strings['recipient_type']['related_module'] = 'Recipient associated with a related module';
$app_list_strings['recipient_type']['target_module'] = 'Recipient associated with the target module';

$app_list_strings['email_field']['to'] = 'To';
$app_list_strings['email_field']['cc'] = 'Cc';
$app_list_strings['email_field']['bcc'] = 'Bcc';

$app_list_strings['interval_list']['weekly'] = 'Weekly';
$app_list_strings['interval_list']['monthly'] = 'Monthly';

// Origin and Target Module List

$app_list_strings['origin_parent_type_survey_display']['Accounts'] = $app_list_strings['moduleList']['Accounts'];
$app_list_strings['origin_parent_type_survey_display']['Contacts'] = $app_list_strings['moduleList']['Contacts'];
$app_list_strings['origin_parent_type_survey_display']['Leads'] = $app_list_strings['moduleList']['Leads'];
$app_list_strings['origin_parent_type_survey_display']['Prospects'] = $app_list_strings['moduleList']['Prospects'];

$app_list_strings['target_parent_type_survey_display']['Accounts'] = $app_list_strings['moduleList']['Accounts'];
$app_list_strings['target_parent_type_survey_display']['Contacts'] = $app_list_strings['moduleList']['Contacts'];
$app_list_strings['target_parent_type_survey_display']['Leads'] = $app_list_strings['moduleList']['Leads'];
$app_list_strings['target_parent_type_survey_display']['Prospects'] = $app_list_strings['moduleList']['Prospects'];


$app_list_strings['moduleList']['bc_survey_automizer'] = 'Survey Automations';
$app_list_strings['moduleList']['bc_automizer_condition'] = 'Survey Automation Conditions';
$app_list_strings['moduleList']['bc_automizer_actions'] = 'Survey Automation Actions';
$app_list_strings['moduleListSingular']['bc_survey_automizer'] = 'Survey Automation';
$app_list_strings['moduleListSingular']['bc_automizer_condition'] = 'Survey Automation Condition';
$app_list_strings['moduleListSingular']['bc_automizer_actions'] = 'Survey Automation Actions';

$app_strings['REDIRECT_URL_INVALID'] = 'Error. Invalid URL. It should be in http://www.google.com format';

// Language related strings
$app_list_strings['moduleList']['bc_survey_language'] = 'Survey Languages';
$app_list_strings['moduleListSingular']['bc_survey_language'] = 'Survey Language';
$app_list_strings['text_direction_list']['left_to_right'] = 'Left To Right';
$app_list_strings['text_direction_list']['right_to_left'] = 'Right To Left';
$app_list_strings['availability_status_list']['enabled'] = 'Enabled';
$app_list_strings['availability_status_list']['disabled'] = 'Disabled';

// Data Piping Dropdown labels
$app_list_strings['sync_module_list']['Accounts'] = 'Accounts';
$app_list_strings['sync_module_list']['Contacts'] = 'Contacts';
$app_list_strings['sync_module_list']['Leads'] = 'Leads';
$app_list_strings['sync_module_list']['Prospects'] = 'Targets';

$app_list_strings['sync_type_list']['create_records'] = 'Create Records';
$app_list_strings['sync_type_list']['create_or_update_records'] = 'Create or Update Records';

$app_list_strings['survey_status_list']['active'] = 'Published';
$app_list_strings['survey_status_list']['inactive'] = 'Unpublished';

// Survey Status :: LoadedTech Customization
$app_list_strings['survey_status_list']['Active'] = 'Active';
$app_list_strings['survey_status_list']['Inactive'] = 'Inactive';
// Survey Status :: LoadedTech Customization END

$app_list_strings['automation_date_options_list']['Today'] = 'Today';
$app_list_strings['automation_date_options_list']['Last_Week'] = 'Last Week';
$app_list_strings['automation_date_options_list']['Last_30_Days'] = 'Last 30 Days';
$app_list_strings['automation_date_options_list']['Next_Week'] = 'Next Week';
$app_list_strings['automation_date_options_list']['Next_30_Days'] = 'Next 30 Days';
$app_list_strings['moduleList']['bc_survey_submit_question'] = 'Survey Submitted Question';
$app_list_strings['moduleListSingular']['bc_survey_submit_question'] = 'Survey Submitted Question';
