<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 8/02/21
 * Time: 08:35 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Call_createSurveySubmission
{
    function createSurveySubmissionCalls($bean, $event, $arguments)
    {
        global $db, $current_user, $app_list_strings;

        if ($bean->status == "Held") {

            // variables
            $idCall = $bean->id;
            $idUsrCalls = $bean->assigned_user_id;
            $nameUsrCalls = $bean->assigned_user_name;
            $idParentCalls = $bean->parent_id;
            $idPersonCalls = $bean->parent_id;
            $listaEncuestas = $app_list_strings['encuestas_ids_list'];
            $beanAccount = BeanFactory::getBean('Accounts', $idParentCalls, array('disable_row_level_security' => true));
            //$usr_email = $beanAccount->email1!=""?1:0;
            $email = $beanAccount->email1 != "" ? 1 : 0;
            $idEncuesta = ($email == 1) ? $listaEncuestas['encuesta_calls_heald_accounts'] : "";

            if (empty($idCall) || $idCall == "") {
                return false;
            }

            //Genera consulta a submission
            //$GLOBALS['log']->fatal('TCT - Consulta BD: Identifica si ya existe envío para survey');
            $query = "select id from bc_survey_submission WHERE parent_id=? and parent_type='Calls' and deleted=0";
            $conn = $db->getConnection();
            $stmt = $conn->executeQuery($query, array($idCall));
            foreach ($stmt->fetchAll() as $row) {
                $idSubmission = $row['id'];
            }

            if (empty($idSubmission) || $idSubmission == "") {
                //Ejecuta proceso para insertar registro
                $idSubmission = create_guid();
                //Cambia valores email/link
                if ($email == 1) {
                    $description = 'Encuesta enviada desde llamada';
                    $last_send_on = 'utc_timestamp()';
                    $mail_status = 'sent successfully';
                    $submission_type = 'Email';
                } else {
                    $description = 'Encuesta enviada desde llamada';
                    $last_send_on = 'null';
                    $mail_status = '';
                    $submission_type = 'Open Ended';
                }

                //Genera insert a tabla bc_survey_submission: Registro de envío de encuesta a destinatario
                $insertS = "INSERT INTO bc_survey_submission
            ('id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 
            'created_by', 'description', 'deleted', 'email_opened', 'survey_send', 'schedule_on', 'status', 'customer_name',
             'resubmit', 'resubmit_counter', 'change_request', 'resend', 'resend_counter', 'recipient_as', 'base_score',
             'obtained_score', 'score_percentage', 'parent_type', 'parent_id', 'target_parent_type', 'target_parent_id',
              'team_id', 'team_set_id', 'submission_type', 'consent_accepted', 'survey_trackdatetime_temp', 'last_send_on',
               'mail_status')
            VALUES
            ( '{$idSubmission}',
              '{$nameUsrCalls}',
              utc_timestamp(),
              utc_timestamp(),
              '{$idUsrCalls}',
              '{$idUsrCalls}',
              '{$description}',
              '0',
              '1',
              '1',
              utc_timestamp(),
              'Pending',
              '{$nameUsrCalls}',
              '0',
              '0',
              'N/A',
              '0',
              '0',
              'to',
              '0',
              '0',
              '0',
              'Calls',
              '{$idCall}',
              'Users',
              '{$idUsrCalls}',
              '1',
              '1',
              '{$submission_type}',
              '0',
              utc_timestamp(),
              {$last_send_on},
              '{$mail_status}'
            );";
                //Ejecuta insert
                $resultInsertS = $db->query($insertS);

                //Genera insert a tabla bc_survey_submission_bc_survey_c: Relación entre envío y encuesta
                $insertSS = "INSERT INTO bc_survey_submission_bc_survey_c
            ('id', 'date_modified', 'deleted', 'bc_survey_submission_bc_surveybc_survey_ida', 
            'bc_survey_submission_bc_surveybc_survey_submission_idb')
            VALUES
            ( UUID(),
              utc_timestamp(),
              '0',
              '{$idEncuesta}',
              '{$idSubmission}'
            );";
                //Ejecuta insert
                $resultInsertSS = $db->query($insertSS);
            }
            //Genera encode Base 64 de url
            $urlSurvey = $idEncuesta . "&ctype=Users&cid=" . $idUsrCalls . "&sub_id=" . $idSubmission;
            //$GLOBALS['log']->fatal('TCT - urlSurvey: '. $urlSurvey);
            $stringBase64 = base64_encode($urlSurvey);
            //$GLOBALS['log']->fatal('TCT - stringBase64: '. $stringBase64);
            //Regresa url en base64
            $GLOBALS['log']->fatal('Respuesta Encuesta Calls'. $stringBase64);
            //return $stringBase64;

        }

    }
}