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
            $lead=$bean->name;
            $codigo=$bean->codigo_vendor_c;
            $idregistro=$urlSugar.$bean->id;
            $GLOBALS['log']->fatal("Realiza retrieve bean de la cuenta referida- notificacion Vendors");
            $accountVendor = BeanFactory::retrieveBean("Accounts", $bean->account_id_c);
            $accountName=$accountVendor->name;
            $accountVendorCode=$accountVendor->codigo_vendor_c;

            //Validamos que si se tiene codigo vendor NO vacío, se manden los correos
            if(!empty($accountVendorCode)){
                //Setea cuerpo de notificacion
                $cuerpoCorreo= $this->CuerpoNotificacion($accountName,$accountVendorCode,$idregistro,$lead);
                //Ejecuta la función para envío de notificaciones a la lista Vendor
                $this->enviarNotificacionVendor("Oportunidad de negocio por Vendor",$cuerpoCorreo,$correosVendor, $idregistro);
            }else{
                $GLOBALS['log']->fatal("No cumple condicion proceso de notificacion Vendors ya que no tiene codigo_vendor_c");
            }
        }else{
            $GLOBALS['log']->fatal("No cumple condicion proceso de notificacion Vendors");
        }
        
    }

 public function CuerpoNotificacion($accountName,$accountVendorCode,$idregistro,$lead){
                  
        $mailHTML = '<font face="verdana" color="#635f5f">
                <br>Estimado asesor: <br><br> Te notificamos que el vendor '.$accountName. ' (<b>'.$accountVendorCode.'</b>) registró una nueva oportunidad de negocio.</b>
                Para visualizarla da clic en el siguiente enlace: <br><br><br><a id="idregistro" href="'. $idregistro.'">Lead '.$lead.'</a>
                
                <br><br>Atentamente</font></p>
                <p class="imagen"><img border="0" width="350" height="107" style="width: 1.5in; height: 1in;" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
                <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
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
        //Añade e itera correos de usuarios Vendor
        $recipients=$app_list_strings['usuarios_vendor_list'];
        foreach ($recipients as $key => $value) {
            $GLOBALS['log']->fatal("Iterando y agregando correos a: ".$value);
            $mailer->addRecipientsTo(new EmailIdentity($value));
        }
        //Itera listas para usuarios con copia de correo (Montserrate y Leonardo)
        $concopia=$app_list_strings['Vendors_cc_list'];
        foreach ($concopia as $key => $value) {
            $GLOBALS['log']->fatal("Iterando y agregando correos de copia : ".$value);
            $mailer->addRecipientsCc(new EmailIdentity($value));
        }
        
        //Envia correos.
        $result = $mailer->send();
        $GLOBALS['log']->fatal("Termina proceso de notificacion Vendors con envío de correo(s)");

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