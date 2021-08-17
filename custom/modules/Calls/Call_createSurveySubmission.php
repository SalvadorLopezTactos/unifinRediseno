<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 8/02/21
 * Time: 08:35 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/utils.php');

class Call_createSurveySubmission
{
    function createSurveySubmissionCalls($bean, $event, $arguments)
    {
        //$GLOBALS["log"]->fatal("LH - Survey NPS :: Inicia");
        //Declara variables globales
        global $db, $current_user, $app_list_strings;
        /* Criterios:
            1) Llamada asignada a Cuenta
            2) Usuario que cierra llamada contiene producto Leasing = 1
            3) Llamada en estatus Realizado
            4) Resultado de llamada; Checklist_expediente,Llamada_servicio  */
        if ($bean->parent_type == 'Accounts' && !empty($bean->parent_id) && $current_user->tipodeproducto_c=='1' && $bean->status == "Held" && $bean->fetched_row['status'] != $bean->status && ($bean->tct_resultado_llamada_ddw_c == "Checklist_expediente" || $bean->tct_resultado_llamada_ddw_c == "Llamada_servicio" )) {
            // Recupera variables de llamada
            //$GLOBALS["log"]->fatal("LH - Survey NPS :: Cumple condición de envío");
            $idCall = $bean->id;
            $idParentCalls = isset($bean->parent_id) ? $bean->parent_id : '';
            $idPersonaCalls = isset($bean->persona_relacion_c) ? $bean->persona_relacion_c : '';
            $idUserCalls = $current_user->id;
            $nameUserCalls = $current_user->full_name;
            $listaEncuestas = isset($app_list_strings['encuestas_ids_list']) ? $app_list_strings['encuestas_ids_list'] : '';
            $idEncuesta = isset($listaEncuestas['encuesta_calls_heald_accounts']) ? $listaEncuestas['encuesta_calls_heald_accounts'] : '';
            $idSubmission = '';
            $emailPersona = '';
            //Recupera cuenta asociada
            $beanAccount = BeanFactory::getBean('Accounts', $idParentCalls, array('disable_row_level_security' => true));
            //Valida que sea Cliente
            if($beanAccount->tipo_registro_cuenta_c == '3'){
                //Moral: Valida que tenga persona asociada
                if ($beanAccount->tipodepersona_c == 'Persona Moral') {
                    if (!empty($idPersonaCalls)) {
                        //Recupera persona relacionada con relación negocio
                        $personaRelacionada = false;
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
                        $resultP = $db->query($queryP);
                        while ($row = $db->fetchByAssoc($resultP)) {
                            $personaRelacionada = true;
                        }
                        if ($personaRelacionada) {
                            $beanPersona = BeanFactory::getBean('Accounts', $idPersonaCalls, array('disable_row_level_security' => true));
                            $namePersonaCalls = $beanPersona->name;
                            $emailPersona = $beanPersona->email1;
                            $nameParentCalls = $beanAccount->name;
                        }
                    }
                } else {
                    $namePersonaCalls = $beanAccount->name;
                    $emailPersona = $beanAccount->email1;
                    $nameParentCalls = $beanAccount->name;
                }

                //Valida generación de encuesta en último trimestre
                $encuestaExistente = $this->existeEncuestaTrimestre($idParentCalls, $idPersonaCalls, $idUserCalls);

                if (!$encuestaExistente && !empty($emailPersona) && !empty($idEncuesta)) {
                    //Ejecuta proceso para insertar registro
                    $idSubmission = create_guid();
                    //Cambia valores email/link
                    $description = 'Encuesta enviada desde llamada';
                    $last_send_on = 'utc_timestamp()';
                    $mail_status = 'sent successfully';
                    $submission_type = 'Email';

                    //Genera insert a tabla bc_survey_submission: Registro de envío de encuesta a destinatario
                    $insertS = "INSERT INTO bc_survey_submission
                      (id, name, date_entered, date_modified, modified_user_id,created_by, description, deleted, email_opened, survey_send, schedule_on, status, customer_name,resubmit, resubmit_counter, change_request, resend, resend_counter, recipient_as, base_score,
                       obtained_score, score_percentage, parent_type, parent_id, target_parent_type, target_parent_id, team_id, team_set_id, submission_type, consent_accepted, survey_trackdatetime_temp, last_send_on, mail_status)
                      VALUES
                      ( '{$idSubmission}',
                        '{$nameUserCalls}',
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
                        '{$nameUserCalls}',
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
                        '{$idUserCalls}',
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
                        (id, date_modified, deleted, bc_survey_submission_bc_surveybc_survey_ida, bc_survey_submission_bc_surveybc_survey_submission_idb)
                        VALUES
                        ( UUID(),
                          utc_timestamp(),
                          '0',
                          '{$idEncuesta}',
                          '{$idSubmission}'
                        )";
                    //Ejecuta insert
                    $resultInsertSS = $db->query($insertSS);
                    //Genera encode Base 64 de url
                    $urlSurvey = $idEncuesta . "&ctype=Users&cid=" . $idUsrCalls . "&sub_id=" . $idSubmission;
                    $stringBase64 = base64_encode($urlSurvey);
                    //$GLOBALS['log']->fatal('Respuesta Encuesta Calls' . $stringBase64 . " current " . $current_user->id . " name " . $current_user->name);
                    $this->sendEmailSurvey($namePersonaCalls, $nameUserCalls, $emailPersona, $stringBase64);

                }
            }
        }
        //$GLOBALS["log"]->fatal("LH - Survey NPS :: Termina");
    }

    // Función para ejecutar envío de correo electrónico: Encuesta: Satisfaccion cliente- Llamada
    function sendEmailSurvey($nombrePersona, $Asesor, $email, $stringBase64)
    {
        //Recupera site_url
        global $sugar_config;
        $sugarHost = $sugar_config['site_url'] . '/survey_submission.php?q=';

        //Genera url de encuesta
        $urlSurvey = $sugarHost . $stringBase64;

        //Establece parámetros de envío
        $timedate = new TimeDate();
        $mailSubject = "¡TU OPINIÓN ES IMPORTANTE!";
        $mailHTML = '<p align="center" class="imagen"><img border="0" style="width:135px;height:103px" id="logoUnifin" src="https://www.unifin.com.mx/img/logo.png"></span></p><br>
          <p align="center" style="font-size: 14pt; font-family: "Arial",sans-serif;"><font face="Arial" color="#032258">Estimado: <b>' . $nombrePersona . '</b>
          <br><br>Recientemente recibiste una llamada de seguimiento por parte del asesor <b>' . $Asesor . '</b>, nos gustaría conocer tu opinión acerca del servicio que has recibido.
          <center>Te invitamos a contestar la siguiente encuesta.<br><br>
          <button style="background-color:#fff;height: 35px;border-radius: 10px;"><a href="'.$urlSurvey.'"color:#032258;>Comenzar la encuesta</a></button>
          </center></font></p>
          <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
          <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #212121;">
          Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
          Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
          No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
          Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        $mailTo = array(
            0 => array(
                'name' => $nombrePersona,
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

    //Función para validar existencia de encuesta en el mismo trimestre
    function existeEncuestaTrimestre($idParentCalls, $idPersonaCalls, $idUserCalls)
    {
        /*
          Validación:
            mismo trimestre y mismo año
            misma cuenta principal
            misma cuenta relacionada (en caso de aplicar)
            mismo asesor
        */
        global $db;
        $existente = false;
        $query = "select submission.id, submission.name, year(submission.date_entered) anio, quarter(submission.date_entered) q, submission.parent_id callId, submission.target_parent_id userId
          from bc_survey_submission submission
            inner join calls on calls.id = submission.parent_id
            inner join calls_cstm callsc on calls.id=callsc.id_c
          where
            calls.parent_id='".$idParentCalls."'
            and year(submission.date_entered) = year(now())
            and quarter(submission.date_entered) = quarter(now())
            and submission.target_parent_id ='".$idUserCalls."'
            and submission.deleted=0 ";
        $query = empty($idPersonaCalls) ? $query.";" :  $query." and callsc.persona_relacion_c='".$idPersonaCalls."' ;";

        //$GLOBALS['log']->fatal('Consulta duplicado ' . $query);

        $result = $db->query($query);
        while ($row = $db->fetchByAssoc($result)) {
            $existente = true;
        }
        //Regresa validación de encuesta existene
        return $existente;
    }
}
