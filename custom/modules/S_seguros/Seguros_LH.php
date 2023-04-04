<?php

class Seguros_LH{

    public function send_notification_ganada($bean = null, $event = null, $args = null){

        global $app_list_strings;

        $etapa = $bean->etapa;
        $emails_seguros_list = $app_list_strings['emails_seguros_list'];
        $send_email = false;
        $id_dynamics = $bean->int_id_dynamics_c;
        $text_cambios = '';
        if( $etapa == 9){
            $text_cambios .= '<ul>';
            if( $bean->fetched_row['tipo_sf_c'] !== $bean->tipo_sf_c ){
                $send_email = true;
                $text_cambios .= '<li><b>Tipo</b>, contenía el valor <b>'. $app_list_strings['tipo_sf_list'][$bean->fetched_row['tipo_sf_c']] .'</b> y se actualizó por <b>'.$app_list_strings['tipo_sf_list'][$bean->tipo_sf_c].'</b></li>';
            }

            if( $bean->fetched_row['tipo_referenciador'] !== $bean->tipo_referenciador ){
                $send_email = true;
                $text_cambios .= '<li><b>Tipo Referenciador</b>, contenía el valor <b>'.$app_list_strings['tipo_referenciador_list'][$bean->fetched_row['tipo_referenciador']] .'</b> y se actualizó por <b>'.$app_list_strings['tipo_referenciador_list'][$bean->tipo_referenciador].'</b></li>';
            }

            if( $bean->fetched_row['empleados_c'] !== $bean->empleados_c ){
                $send_email = true;
                $text_cambios .= '<li><b>Referenciador</b>, contenía el valor <b>'. $bean->fetched_row['empleados_c'] .'</b> y se actualizó por <b>'.$bean->empleados_c.'</b></li>';
            }

            if( $bean->fetched_row['comision_c'] !== $bean->comision_c ){
                $send_email = true;
                $text_cambios .= '<li><b>Comisión</b>, contenía el valor <b>'. $bean->fetched_row['comision_c'] .'</b> y se actualizó por <b>'.$bean->comision_c.'</b></li>';
            }
            $text_cambios .= '</ul>';

        }
        
        if( $send_email ){
            $body_correo = $this->buildBodyEmail( $id_dynamics, $text_cambios);
            $this->sendEmailNotification( $emails_seguros_list, $body_correo );
        }
        
    }

    public function buildBodyEmail($id_dynamics,$text_cambios){

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>Equipo Inter,</b><br>
            La oportunidad <b>'.$id_dynamics.'</b> ha sido actualizada desde el CRM de Unifin.<br>
            <br>Pedimos su apoyo con la actualización en el CRM de Inter de los siguientes cambios:<br>'.
            $text_cambios.'<br>
            <br><br>Atentamente Unifin</font></p>
            <br><br><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png">
            <br><span style="font-size:8.5pt;color:#757b80">____________________________________________</span>
            <p class="MsoNormal" style="text-align: justify;">
              <span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro <a href="https://www.unifin.com.mx/aviso-de-privacidad" target="_blank">Aviso de Privacidad</a>  publicado en <a href="http://www.unifin.com.mx/" target="_blank">www.unifin.com.mx</a>
              </span>
            </p>';

        return $mailHTML;
    }

    public function sendEmailNotification($emails_address,$body_correo){

        try{
            global $app_list_strings;
            //$email_copia = 'irma.rodriguez@unifin.com.mx';
            $email_copia = $app_list_strings['email_cc_seguros_list']['1'];
            $name_email_copia = 'Irma Rodriguez';
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject('UNIFIN - Actualización Oportunidad de Seguros');
            $body = trim($body_correo);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            for ($i=0; $i < count($emails_address); $i++) {
                $GLOBALS['log']->fatal("AGREGANDO CORREOS DESTINATARIOS: ".$emails_address[$i]);
                $mailer->addRecipientsTo(new EmailIdentity($emails_address[$i], $emails_address[$i]));
            }
            $mailer->addRecipientsCc(new EmailIdentity($email_copia, $name_email_copia));
            $result = $mailer->send();

        } catch (Exception $e){
            $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
            $GLOBALS['log']->fatal(print_r($e,true));

        }

    }
}