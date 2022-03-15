<?php
/**
 * User: Adrian Arauz
 * Date: 14/03/2022
 */
class NotificacionVendor
{
function notificaVendors($bean, $event, $arguments)
    {
        global $current_user,$db;

        if($bean->origen_c=="8" && $bean->date_entered==$bean->date_modified){
            $GLOBALS['log']->fatal("Inicia proceso de notificacion Vendors");
            //Se arma cuerpo de la notificación
            $urlSugar=$GLOBALS['sugar_config']['site_url'].'/#Leads/';
            $vendor=$bean->name;
            $codigo=$bean->codigo_vendor_c;
            $idregistro=$bean->id;
            //Setea cuerpo de notificacion
            $cuerpoCorreo= $this->CuerpoNotificacion($vendor,$codigo,$idregistro);
            //Ejecuta la función para envío de notificaciones a la lista Vendor
            $this->enviarNotificacionVendor("Oportunidad de negocio por Vendor",$cuerpoCorreo,$correosVendor, $idregistro);
        }else{
            $GLOBALS['log']->fatal("No cumple condicion proceso de notificacion Vendors");
        }
        
    }

 public function CuerpoNotificacion($vendor,$codigo,$idregistro){
                  
        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
                <br><br>Estimado asesor: <br><br> Te notificamos que el vendor '.$vendor. '(<b>'.$codigo.'</b>) registró una nueva oportunidad de negocio.</b>
                <br><br>Para visualizarla da clic en el siguiente enlace: <a id="idregistro" href="'. $idregistro.'">Lead '.$vendor.'</a>
                
                <br><br>Atentamente...</font></p>
                <br><p class="imagen"><img border="0" width="350" height="107" style="width: 1.5in; height: 1in;" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
                <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
                <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
                Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
                Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
                No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
                Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';
        
        return $mailHTML;
}

 public function enviarNotificacionVendor($asunto,$cuerpoCorreo,$recipients=array(),$idregistro){
    
    global $app_list_strings;
        
    $cc ='';
    $GLOBALS['log']->fatal("Correo a: ".print_r($recipients,true));
    try{
        $mailer = MailerFactory::getSystemDefaultMailer();
        $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
        $mailer->setSubject($asunto);
        $body = trim($cuerpoCorreo);
        $mailer->setHtmlBody($body);
        $mailer->clearRecipients();
        //$mailer->addRecipientsTo(new EmailIdentity($correoDirector, $nombreDirector));
        $recipients=$app_list_strings['usuarios_vendor_list'];
        foreach ($recipients as $key => $value) {
            $GLOBALS['log']->fatal("Iterando y agregando correos a: ".$value);
            $mailer->addRecipientsTo(new EmailIdentity($value));
        }
        
        //Envia correos.
        $result = $mailer->send();

    } catch (Exception $e){
        $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email.");
        $GLOBALS['log']->fatal("Exception ".$e);

        } catch (MailerException $me) {
            $message = $me->getMessage();
            switch ($me->getCode()) {
                case \MailerException::FailedToConnectToRemoteServer:
                $GLOBALS["log"]->fatal("BeanUpdatesMailer :: error sending email, system smtp server is not set");
                break;
                default:
                $GLOBALS["log"]->fatal("BeanUpdatesMailer :: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                break;
            }
        }
}    


}    