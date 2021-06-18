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
        global $db, $current_user, $app_list_strings;

        if ($current_user->tipodeproducto_c=='1' && $bean->status == "Held" && ($bean->tct_resultado_llamada_ddw_c == "Checklist_expediente" || $bean->tct_resultado_llamada_ddw_c == "Llamada_servicio" )) {

            // variables
            $idCall = $bean->id;
            $idParentCalls = $bean->parent_id;
            $idPersonaCalls = $bean->persona_relacion_c;
            $listaEncuestas = $app_list_strings['encuestas_ids_list'];
            $beanAccount = BeanFactory::getBean('Accounts', $idParentCalls, array('disable_row_level_security' => true));
            if($beanAccount->tipo_registro_cuenta_c == '3'){
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
                    $beanPersona = BeanFactory::getBean('Accounts', $idPersonaCalls, array('disable_row_level_security' => true));
                    $nameParentCalls = $beanPersona->name;
                    $emailPersona = $beanPersona->email1;
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
                $GLOBALS['log']->fatal('TCT - urlSurvey: ' . $idUsrCalls . "  " . $nameUsrCalls);

                $respuest = $this->existeEncuestaTrimestre($beanAccount->tipodepersona_c, $idUsrCalls,$beanAccount->id);

                if (!empty($idUsrCalls) && !empty($nameUsrCalls) && $respuest) {
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
                    $urlSurvey = $idEncuesta . "&ctype=Users&cid=" . $idUsrCalls . "&sub_id=" . $idSubmission;
                    $stringBase64 = base64_encode($urlSurvey);
                    //Regresa url en base64
                    $GLOBALS['log']->fatal('Respuesta Encuesta Calls' . $stringBase64 . " current " . $current_user->id . " name " . $current_user->name);

                    $correo = $beanAccount->tipodepersona_c == 'Persona Moral' ? $emailPersona : $beanAccount->email1;
                    $this->sendEmailSurvey($nameParentCalls, $bean->assigned_user_name, $correo, $stringBase64);

                }
            }
        }
    }

    /*
   * Función para ejecutar envío de correo electrónico: Encuesta: Satisfaccion cliente- Llamada
  */
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
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: "Arial",sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';
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

    function existeEncuestaTrimestre($tipoRegimen, $usuario, $idCuenta)
    {
        global $db;
        $dateStrHoy = date('Y-m-d H:i:s');
        $anoHoy = date("Y");
        $month = date("n", strtotime($dateStrHoy));
        $hoyTrimestres = ceil($month / 3);

        $GLOBALS['log']->fatal('Trimestre hoy ' . $hoyTrimestres);
        $GLOBALS['log']->fatal('Año hoy ' . $anoHoy);

        if ($tipoRegimen == 'Persona Moral') {
            $sentencia = "AND calls_cstm.persona_relacion_c='{$usuario}'";
        } else {
            $sentencia = "AND user_creador.id='{$usuario}'";
        }
        $queryEncuesta = "SELECT
  CONVERT_TZ(submission.submission_date, '+00:00', @@global.time_zone) FechaRespuesta,
  accounts.id                                                          IdCRMCliente,
  accounts_cstm.tipodepersona_c                                        'Tipo de Cliente',
  submission.name                                                      'Nombre Persona Relacionada',
  calls_cstm.persona_relacion_c                                        'Id CRM Personas Relacionada',
  concat(user_creador.first_name, ' ', user_creador.last_name)         'Nombre Asesor',
  user_creador.id                                                      'Id CRM Asesor'

FROM bc_survey_submit_answer_calculation surveyCalculation
  INNER JOIN bc_survey survey
    ON survey.id = surveyCalculation.sent_survey_id
       AND survey.deleted = 0
  INNER JOIN bc_survey_submission submission
    ON submission.id = surveyCalculation.submission_id
       AND submission.deleted = 0
  LEFT JOIN calls
    ON calls.id = submission.parent_id
       AND calls.deleted = 0
  LEFT JOIN calls_cstm
    ON calls_cstm.id_c = calls.id
  LEFT JOIN accounts
    ON accounts.id = calls.parent_id
       AND calls.parent_type = 'Accounts'
       AND accounts.deleted = 0
  INNER JOIN accounts_cstm
    ON accounts_cstm.id_c = accounts.id
  INNER JOIN users_cstm
    ON users_cstm.id_c = submission.target_parent_id
  INNER JOIN users user_creador
    ON user_creador.id = calls.created_by
WHERE
  survey.name = 'ENCUESTA DE SEGUIMIENTO'
  AND submission.parent_type = 'Calls'
    AND accounts.id='{$idCuenta}'";
        $orderBy = "GROUP BY  submission.name, submission.id, calls.name, accounts.name, submission.submission_date ORDER BY  submission.submission_date DESC LIMIT 1";

        $consulta = $queryEncuesta . $sentencia . $orderBy;
        //$GLOBALS['log']->fatal('Cosnulta query encuestas ' . $consulta);
        $Result = $db->query($consulta);
        while ($row = $db->fetchByAssoc($Result)) {
            //$GLOBALS['log']->fatal('Row consulta ' . $row);
            //$GLOBALS['log']->fatal('Row consulta ' . $row['FechaRespuesta']);
            $fechaEncuesta = $row['FechaRespuesta'];
        }
        $dateEncuesta = $fechaEncuesta;
        $monthEncuesta = date("n", strtotime($dateEncuesta));
        $TrimestresEncuesta = ceil($monthEncuesta / 3);
        $anoEncuesta = date("Y", strtotime($dateEncuesta));

        //$GLOBALS['log']->fatal('Trimestre encuesta ' . $TrimestresEncuesta);
        //$GLOBALS['log']->fatal('Año encuesta ' . $anoEncuesta);
        $bandera = false;

        if ($hoyTrimestres == $TrimestresEncuesta) {

            if ($anoHoy == $anoEncuesta) {
                $bandera = false;
            } else {
                $bandera = true;
            }
        } else {
            $bandera = true;
        }
        return $bandera;
    }
}
