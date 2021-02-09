<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 8/02/21
 * Time: 08:30 PM
 */
$hook_array['after_save'][] = Array(
    5,
    'Genera Registro de encuentas createSurveySubmission ',
    'custom/modules/Calls/Call_createSurveySubmission.php',
    'Call_createSurveySubmission',
    'createSurveySubmissionCalls'
);