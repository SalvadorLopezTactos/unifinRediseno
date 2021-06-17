<?php
array_push($job_strings, 'job_resumen_encuestas_nps');

function job_resumen_encuestas_nps()
{
    try {

        $GLOBALS['log']->fatal('---INICIA JOB RESUMEN ENCUESTA NPS---');

        global $app_list_strings, $sugar_config;
        $hoy = date("d/m/Y");
        $lista_destinatario = $app_list_strings['destinatario_nps_list']; //USUARIO DESTINATARIO DINAMICO "ARELLY SILVA"
        $id_informe_nps_list = $app_list_strings['id_informe_nps_list']; //ID DEL INFORME AVANZADO ENCUESTA DE SEGUIMIENTO LLAMADAS NPS - 7 DIAS
        foreach ($id_informe_nps_list as $key => $valueID) {
            $hostSugar = $sugar_config['site_url'] . '/#bwc/index.php?module=ReportMaker&offset=3&stamp=1623784938029538100&return_module=ReportMaker&action=DetailView&record='.$valueID;
        }

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
                        Cliente: <b>' . $cliente . '</b>, persona que contestó la encuesta 
                        <br><b>' . $personaContesto . '</b> y el asesor que ejecutó llamada para envío de encuesta fue <b>' . $asesor . '</b>,</li></ul></font>';
                    }
                    
                    $mailHTMLRecords .= '<br>Consultar Registro: <a href="' . $hostSugar . '" target="_blank">Informe</a>';
                }

                if ($totalRegistros > 0) {
                    $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Estimada <b>' . $nombreUsuario . '</b>
                    <br><br>Se le informa que el día de hoy <b>' . $hoy . '</b> se recibieron <b>' . $totalRegistros . '</b> encuestas NPS por parte de los siguientes clientes:
                    </font></p>'.$mailHTMLRecords.'
                    <br><br><br>
                    <p align="justify"><font face="verdana" color="#635f5f">Atentamente Unifin</font></p>
                    <br><p class="imagen"><img id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
                    <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">__________<wbr>______<u></u><u></u></span></p>
                    <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                    Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. 
                    Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                    Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, 
                    quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, 
                    a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                    No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                    Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y 
                    privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;
                    </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;">
                    <a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" 
                    data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg">
                    <span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span>
                    <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br/></span>
                    <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;">
                    <a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" 
                    data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ">
                    <span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
                
                } else {
                    $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><br><b>Hoy no se respondieron encuestas</b></font></p>
                    <br><br><br>
                    <p align="justify"><font face="verdana" color="#635f5f">Atentamente Unifin</font></p>
                    <br><p class="imagen"><img id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
                    <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">__________<wbr>______<u></u><u></u></span></p>
                    <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                    Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. 
                    Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                    Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, 
                    quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, 
                    a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                    No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                    Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y 
                    privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;
                    </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;">
                    <a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" 
                    data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg">
                    <span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span>
                    <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br/></span>
                    <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;">
                    <a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" 
                    data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ">
                    <span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
                }

                $mailer = MailerFactory::getSystemDefaultMailer();
                $mailer->getMailTransmissionProtocol();
                $mailer->setSubject("Resumen de respuestas de encuestas NPS Transaccional");
                $body = trim($mailHTML);
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
