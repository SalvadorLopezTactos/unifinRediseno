<?php
array_push($job_strings, 'job_notifica_vencimiento');

function job_notifica_vencimiento()
{
    try {

        $GLOBALS['log']->fatal('Comienza job para notificar vencimiento de casos');

        $querySelectCasos = "select c.id, c.name, c.assigned_user_id, c.follow_up_datetime,c.status, concat(u.first_name, ' ' , u.last_name) user_name, e.email_address
           from cases c
           inner join cases_cstm cs on cs.id_c =c.id
           inner join users u on u.id = c.assigned_user_id
           inner join email_addr_bean_rel eb on eb.bean_id = c.assigned_user_id and eb.deleted=0
           inner join email_addresses e on e.id=eb.email_address_id and e.deleted=0
           where follow_up_datetime BETWEEN DATE_SUB(UTC_TIMESTAMP(), INTERVAL 24 HOUR) AND UTC_TIMESTAMP()
           and c.deleted=0
           and c.status != '3'
           limit 100;";

        $resultSelect = $GLOBALS['db']->query($querySelectCasos);
        if( $resultSelect->num_rows > 0 ){

            while ($row = $GLOBALS['db']->fetchByAssoc($resultSelect)) {

                $idCaso = $row['id'];
                $asunto = $row['name'];
                $nombreUsuario = $row['user_name'];
                $correo = $row['email_address'];
                $body_correo = bodyEmail( $idCaso, $asunto, $nombreUsuario);
                sendEmailVencimiento( $correo, $asunto, $body_correo );
            }

        }else{
            $GLOBALS['log']->fatal('No se encontraron cuentas que requieran envío de notificación');
        }
        
        $GLOBALS['log']->fatal('Termina job para notificar vencimiento de casos');
        return true;


    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Error: " . $e->getMessage());
    }
}

function bodyEmail( $idCaso, $asunto, $nombreUsuario){
    global $sugar_config;
    $url = $sugar_config['site_url'];

    $linkCuenta = '<a href="'.$url.'/#Cases/'. $idCaso .'">'.$asunto.'</a>';

    $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
        Hola <b>'.$nombreUsuario.'</b>.<br>
      
        Hemos identificado que el caso ' .$linkCuenta. ' ha vencido y no se ha completado. Solicitamos tu apoyo para la atención del mismo.
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

function sendEmailVencimiento( $email_address,$asunto, $body_correo ){

    try{
        global $app_list_strings;
        $mailer = MailerFactory::getSystemDefaultMailer();
        $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
        $mailer->setSubject('UNIFIN CRM - Vencimiento de caso '.$asunto);
        $body = trim($body_correo);
        $mailer->setHtmlBody($body);
        $mailer->clearRecipients();
        $mailer->addRecipientsTo(new EmailIdentity($email_address, $email_address));
        $result = $mailer->send();

    } catch (Exception $e){
        $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email ");
        $GLOBALS['log']->fatal(print_r($e,true));

    }

}
