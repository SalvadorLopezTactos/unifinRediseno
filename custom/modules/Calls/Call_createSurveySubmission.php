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

        if ($bean->status == "Held" && ($bean->tct_resultado_llamada_ddw_c == "Checklist_expediente" ||
                ($bean->tct_resultado_llamada_ddw_c == "Llamada_servicio" && $bean->detalle_resultado_c == 9))) {

            // variables
            $idCall = $bean->id;
            $idParentCalls = $bean->parent_id;
            $idPersonaCalls = $bean->persona_relacion_c;
            $listaEncuestas = $app_list_strings['encuestas_ids_list'];
            $beanAccount = BeanFactory::getBean('Accounts', $idParentCalls, array('disable_row_level_security' => true));

            if ($beanAccount->tipodepersona_c == 'Persona Moral') {
                $queryP = "select t2.account_id1_c,ac.name,t1.relaciones_activas
FROM rel_relaciones_accounts_1_c rel
  INNER JOIN rel_relaciones t1
    ON t1.id=rel.rel_relaciones_accounts_1rel_relaciones_idb
  INNER JOIN rel_relaciones_cstm t2
    ON t2.id_c=t1.id
  INNER join accounts ac
  ON ac.id=t2.account_id1_c
WHERE rel.rel_relaciones_accounts_1accounts_ida='{$idParentCalls}'
      AND t2.account_id1_c='{$idPersonaCalls}'
      AND t1.relaciones_activas LIKE '%^Negocios^%'";

                $result = $db->query($queryP);
                $row = $db->fetchByAssoc($result);
                $idUsrCalls = $row['account_id1_c'];
                $nameUsrCalls = $row['name'];
                $nameParentCalls = $bean->parent_name;
                $beanPersona = BeanFactory::getBean('Accounts', $idPersonaCalls, array('disable_row_level_security' => true));
                $emailPersona=$beanPersona->email1;
            } else {
                $idUsrCalls = $bean->assigned_user_id;
                $nameUsrCalls = $bean->assigned_user_name;
                $nameParentCalls = $bean->parent_name;

            }

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
            $GLOBALS['log']->fatal('TCT - urlSurvey: '. $idUsrCalls . "  " .$nameUsrCalls);

            if (!empty($idUsrCalls) && !empty($nameUsrCalls)) {
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
            (id, name, date_entered, date_modified, modified_user_id, 
            created_by, description, deleted, email_opened, survey_send, schedule_on, status, customer_name,
             resubmit, resubmit_counter, change_request, resend, resend_counter, recipient_as, base_score,
             obtained_score, score_percentage, parent_type, parent_id, target_parent_type, target_parent_id,
              team_id, team_set_id, submission_type, consent_accepted, survey_trackdatetime_temp, last_send_on,
               mail_status)
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
              '{$bean->assigned_user_id}',
              '1',
              '1',
              '{$submission_type}',
              '0',
              utc_timestamp(),
              {$last_send_on},
              '{$mail_status}'
            )";
                    //Ejecuta insert
                    $resultInsertS = $db->query($insertS);

                    //Genera insert a tabla bc_survey_submission_bc_survey_c: Relación entre envío y encuesta
                    $insertSS = "INSERT INTO bc_survey_submission_bc_survey_c
            (id, date_modified, deleted, bc_survey_submission_bc_surveybc_survey_ida, 
            bc_survey_submission_bc_surveybc_survey_submission_idb)
            VALUES
            ( UUID(),
              utc_timestamp(),
              '0',
              '{$idEncuesta}',
              '{$idSubmission}'
            )";
                    //Ejecuta insert
                    $resultInsertSS = $db->query($insertSS);
                }
                //Genera encode Base 64 de url
                $urlSurvey = $idEncuesta . "&ctype=User&cid=" . $idUsrCalls . "&sub_id=" . $idSubmission;
                $stringBase64 = base64_encode($urlSurvey);
                //Regresa url en base64
                $GLOBALS['log']->fatal('Respuesta Encuesta Calls' . $stringBase64);

                $correo=$beanAccount->tipodepersona_c == 'Persona Moral'?$emailPersona:$beanAccount->email1;
                $this->sendEmailSurvey($nameParentCalls,$bean->assigned_user_name,$correo,$stringBase64);

            }


        }

    }

    /*
   * Función para ejecutar envío de correo electrónico: Encuesta: Satisfaccion cliente- Llamada
  */
    function sendEmailSurvey($nombrePersona,$Asesor,$email,$stringBase64)
    {
        //Recupera site_url
        global $sugar_config;
        $sugarHost = $sugar_config['site_url'] . '/survey_submission.php?q=';

        //Genera url de encuesta
        $urlSurvey = $sugarHost . $stringBase64;

        //Establece parámetros de envío
        $timedate = new TimeDate();
        $mailSubject = "Encuesta de satisfacción";
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">HOLA! <b>'. $nombrePersona .'</b>
      <br><br>Recientemente recibiste una llamada de seguimiento por parte del asesor <b>'.$Asesor.'</b> y nos gustaría conocer tu opinión acerca del servicio que has recibido.</font></p>
      <center><a href="'. $urlSurvey .'">Comenzar la encuesta</a><center>';
        $mailTo = array(
            0 => array(
                'name' => $nombrePersona ,
                'email' => $email,
            )
        );

        //Prepara ejecución de correo
        try {
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($mailSubject);
            $body = trim($mailHTML);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($email, $nombrePersona));

            //Ejecuta
            $result = $mailer->send();
            if ($result) {
                //$GLOBALS["log"]->fatal("surveyNotHeld :: Se envío correctamente: " . $urlSurvey);
            } else {
                $GLOBALS["log"]->fatal("surveyNotHeld :: El correo no pudo realizarse de forma correcta");

            }
        } catch (MailerException $me) {
            $message = $me->getMessage();
            switch ($me->getCode()) {
                case \MailerException::FailedToConnectToRemoteServer:
                    $GLOBALS["log"]->fatal("surveyNotHeld :: error sending email, system smtp server is not set");
                    break;
                default:
                    $GLOBALS["log"]->fatal("surveyNotHeld :: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                    break;
            }
        }
    }
}
