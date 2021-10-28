<?php

require_once 'include/SugarPHPMailer.php';
// require_once 'modules/Administration/Administration.php';

class bloqueo_clientes_vita
{

    public function enviaNotificacionBloqueo($bean = null, $event = null, $args = null)
    {
        $linkTarea = $GLOBALS['sugar_config']['site_url'] . '/#Tasks/' . $bean->id;
        $fechas = new DateTime($bean->date_due);
        $fechaVencimiento = $fechas->format('Y-m-d');
        $hoy = date("Y-m-d");

        // Fecha de vencimiento igual al día actual y no tiene resultado de bloqueo
        if ($fechaVencimiento == $hoy && $bean->resultado_bloqueo_c == "") {

            // Motivo de bloqueo INFORMACION ALTERADA
            if ($bean->motivo_bloqueo_c == '1') {

                $account = BeanFactory::getBean('Accounts', $bean->parent_id);
                $nombreCuenta = $account->name;
                $user = BeanFactory::getBean('Users', $account->user_id_c);


                if (!empty($user->email1)) {

                    $correo = $user->email1;
                    $nombre = $user->nombre_completo_c;
                    $users = BeanFactory::getBean('Users', $bean->created_by);
                    $creador = $users->nombre_completo_c;
                    // $envio_usuarios_especificos = 0;

                    if($account->user_id_c == $bean->assigned_user_id) {
                    
                        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
                        El equipo de Tarjeta de Crédito, a través del asesor <b>' . $creador . '</b> solicita el bloqueo del cliente <b>' . $nombreCuenta . '</b>, 
                        ya que durante la acreditación del mismo se detectó que presentó información alterada.
                        <br><br>Asunto: <b><a id="linkTarea" href="' . $linkTarea . '">' . $bean->name . '</a></b>
                        <br><br>Descripción: <b>' . $bean->description . '</b>
                        <br><br>¿Autoriza el bloqueo de este cliente? 
                        
                        <br><br>Sí<Enlace para autorizar> y No<Enlace para rechazar>

                        <br><br>Atentamente Unifin</font></p>
                        <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
                        <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                        Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                        Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                        No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                        Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;
                        </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener">
                        <span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;">
                        <a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';

                        // $envio_usuarios_especificos = 1;
                    }

                    $mailer = MailerFactory::getSystemDefaultMailer();
                    $mailer->getMailTransmissionProtocol();
                    $mailer->setSubject('Solicitud de bloqueo de Cliente: ' . $nombreCuenta);
                    $body = trim($mailHTML);
                    $mailer->setHtmlBody($body);
                    $mailer->clearRecipients();
                    $mailer->addRecipientsTo(new EmailIdentity($correo, $nombre));
                    // if ($envio_usuarios_especificos == 1) {
                    //     //Enviar copia a usuarios especificos solo si el asesor leasing de la cuenta es el mismo que el asignado de la Tarea
                    //     $lista_usuarios_copia = $app_list_strings["users_copia_tareas_list"];
                    //     foreach ($lista_usuarios_copia as $key => $value) {
                    //         $id_usuario = $lista_usuarios_copia[$key];
                    //         $userCopia = BeanFactory::getBean('Users', $id_usuario);
                    //         if (!empty($userCopia)) {
                    //             $correoUserCopia = $userCopia->email1;
                    //             $nombreUserCopia = $userCopia->nombre_completo_c;
                    //             $mailer->addRecipientsCc(new EmailIdentity($correoUserCopia, $nombreUserCopia));
                    //         }
                    //     }
                    // }
                    $result = $mailer->send();
                }
            }

            // Motivo de bloqueo PLD
            // if ($bean->motivo_bloqueo_c == '2') {

            //     $account = BeanFactory::getBean('Accounts', $bean->parent_id);
            //     $nombreCuenta = $account->name;
            //     $user = BeanFactory::getBean('Users', $account->user_id_c);


            //     if (!empty($user->email1)) {

            //         $correo = $user->email1;
            //         $nombre = $user->nombre_completo_c;
            //         $users = BeanFactory::getBean('Users', $bean->created_by);
            //         $creador = $users->nombre_completo_c;
            //         // $envio_usuarios_especificos = 0;


            //         $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
            //         El equipo de Tarjeta de Crédito, a través del asesor <b>' . $creador . '</b> solicita el bloqueo del cliente <b>' . $nombreCuenta . '</b>, 
            //         ya que durante la acreditación del mismo se detectó que presentó información alterada.
            //         <br><br>Asunto: <b><a id="linkTarea" href="' . $linkTarea . '">' . $bean->name . '</a></b>
            //         <br><br>Descripción: <b>' . $bean->description . '</b>
            //         <br><br>¿Autoriza el bloqueo de este cliente? 
                    
            //         <br><br>Sí<Enlace para autorizar> y No<Enlace para rechazar>

            //         <br><br>Atentamente Unifin</font></p>
            //         <br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
            //         <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
            //         Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
            //         Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
            //         No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
            //         Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;
            //         </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener">
            //         <span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;">
            //         <a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';

            //         // $envio_usuarios_especificos = 1;

            //         $mailer = MailerFactory::getSystemDefaultMailer();
            //         $mailer->getMailTransmissionProtocol();
            //         $mailer->setSubject('Solicitud de bloqueo de Cliente: ' . $nombreCuenta);
            //         $body = trim($mailHTML);
            //         $mailer->setHtmlBody($body);
            //         $mailer->clearRecipients();
            //         $mailer->addRecipientsTo(new EmailIdentity($correo, $nombre));
            //         // if ($envio_usuarios_especificos == 1) {
            //         //     //Enviar copia a usuarios especificos solo si el asesor leasing de la cuenta es el mismo que el asignado de la Tarea
            //         //     $lista_usuarios_copia = $app_list_strings["users_copia_tareas_list"];
            //         //     foreach ($lista_usuarios_copia as $key => $value) {
            //         //         $id_usuario = $lista_usuarios_copia[$key];
            //         //         $userCopia = BeanFactory::getBean('Users', $id_usuario);
            //         //         if (!empty($userCopia)) {
            //         //             $correoUserCopia = $userCopia->email1;
            //         //             $nombreUserCopia = $userCopia->nombre_completo_c;
            //         //             $mailer->addRecipientsCc(new EmailIdentity($correoUserCopia, $nombreUserCopia));
            //         //         }
            //         //     }
            //         // }
            //         $result = $mailer->send();
            //     }
            // }
        }
    }
}
