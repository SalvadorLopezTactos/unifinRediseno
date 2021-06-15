<?php
array_push($job_strings, 'job_resumen_encuestas_nps');

function job_resumen_encuestas_nps()
{
    try {

        $GLOBALS['log']->fatal('---INICIA JOB RESUMEN ENCUESTA NPS---');

        global $app_list_strings;
        $hoy = date("d/m/Y");
        $lista_destinatario = $app_list_strings['destinatario_nps_list']; //USUARIO DESTINATARIO DINAMICO "ARELLY SILVA"

        foreach ($lista_destinatario as $key => $value) {

            $usuario = BeanFactory::getBean('Users', $value, array('disable_row_level_security' => true));

            if (!empty($usuario)) {

                $correo = $usuario->email1;
                $nombreUsuario = $usuario->nombre_completo_c;

                $query = "SELECT
                accounts.name	'Cliente' ,
                CASE WHEN accounts_cstm.tipodepersona_c ='Persona Moral' THEN submission.name END 'PersonaContesto',
                concat(user_creador.first_name, ' ', user_creador.last_name) 'Asesor',
                submission.date_entered 'FechaEnvio',
                submission.submission_date,
                date_add(now(),interval -1 day)
              FROM bc_survey_submit_answer_calculation surveyCalculation
                INNER JOIN bc_survey survey ON survey.id = surveyCalculation.sent_survey_id AND survey.deleted = 0
                INNER JOIN bc_survey_submission submission ON submission.id = surveyCalculation.submission_id AND submission.deleted = 0
                INNER JOIN bc_survey_questions question ON question.id = surveyCalculation.question_id AND question.deleted = 0
                LEFT JOIN bc_survey_answers answer ON answer.id = surveyCalculation.submit_answer_id AND answer.deleted = 0
                LEFT JOIN calls ON calls.id = submission.parent_id AND calls.deleted = 0
                LEFT JOIN calls_cstm ON calls_cstm.id_c = calls.id
                INNER JOIN accounts ON accounts.id = calls.parent_id AND calls.parent_type = 'Accounts' AND accounts.deleted = 0
                INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id 
                INNER JOIN accounts_uni_productos_1_c ap ON ap.accounts_uni_productos_1accounts_ida = accounts.id
                INNER JOIN uni_productos up ON up.id = ap.accounts_uni_productos_1uni_productos_idb AND up.deleted = 0
                INNER JOIN uni_productos_cstm upc ON upc.id_c = up.id 
                INNER JOIN users_cstm ON users_cstm.id_c = submission.target_parent_id
                INNER JOIN users user_creador ON user_creador.id = calls.created_by
              WHERE
                survey.name = 'ENCUESTA DE SATISFACCIÓN'
                AND submission.parent_type = 'Calls'
                AND up.tipo_producto = 1
                AND submission.submission_date is not null    
                AND submission.submission_date >= date_add(now(),interval -1 day)
              GROUP BY
                submission.name,
                submission.id,
                calls.name,
                accounts.name,
                submission.submission_date
              ORDER BY submission.submission_date DESC";

                $result = $GLOBALS['db']->query($query);
                $conteo = $result->num_rows;
                $totalRegistros = 0;
                $mailHTMLRecords = '';

                if ($conteo > 0) {
                    while ($nps = $GLOBALS['db']->fetchByAssoc($result)) {
                        $cliente = $nps['Cliente'];
                        $personaContesto = $nps['PersonaContesto'];
                        $asesor = $nps['Asesor'];

                        $totalRegistros++;

                        $mailHTMLRecords .= '<font face="verdana" color="#635f5f"><ul><li>
                        <br><br>Cliente: ' . $cliente . ', persona que contestó la encuesta: 
                        <br>' . $personaContesto . ' y el asesor que ejecutó llamada para envío de encuesta fue:  ' . $asesor . ',';
                    }
                    
                    $mailHTMLRecords .= '<br>consultar registro <a id="InformesNPS" href="#bwc/index.php?module=ReportMaker&action=index&return_module=ReportMaker&return_action=index"></a></li></ul></font>';
                }

                if ($totalRegistros > 0) {
                    $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimada <b>' . $nombreUsuario . '</b>
                    <br><br>Se le informa que el día de hoy ' . $hoy . ' se generaron un total de ' . $totalRegistros . ' los cuales se resumen a continuación:
                    </font></p>'.$mailHTMLRecords;
                
                } else {
                    $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><br><b>Hoy no se respondieron encuestas</b></font></p>';
                }

                $mailer = MailerFactory::getSystemDefaultMailer();
                $mailer->getMailTransmissionProtocol();
                $mailer->setSubject("Resumen de respuestas de encuestas NPS Transaccional");
                $body = trim($mailHTML);
                $GLOBALS['log']->fatal('BODY HTML NPS');
                $GLOBALS['log']->fatal($body);
                $mailer->setHtmlBody($body);
                $mailer->clearRecipients();
                $mailer->addRecipientsTo(new EmailIdentity($correo, $usuario->first_name . ' ' . $usuario->last_name));
                $mailer->send();
            }
        }

        $GLOBALS['log']->fatal('---FINALIZA JOB RESUMEN ENCUESTA NPS---');
        return true;

    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Error: " . $e->getMessage());
    }
}
