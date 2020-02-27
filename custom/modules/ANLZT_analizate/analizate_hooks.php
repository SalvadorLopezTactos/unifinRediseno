<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 24/02/20
 * Time: 11:36 AM
 */
require_once 'include/SugarPHPMailer.php';
require_once 'include/utils/file_utils.php';

class analizate_hooks  {
    public function EnvioMail($bean = null, $event = null, $args = null) {
        if ($bean->estado==1) {
            $GLOBALS['log']->fatal('Entra LH de Analizate');
            //file_put_contents($archivo, $texto_archivo, FILE_APPEND | LOCK_EX);
            $cuenta = BeanFactory::retrieveBean('Accounts', $bean->anlzt_analizate_accountsaccounts_ida);
            $correo = $cuenta->email1;
            $full_name = $cuenta->name;
            $rfc = $cuenta->rfc_c;
            $idCuenta = $cuenta->id;

            $url = $bean->url_portal;
            $GLOBALS['log']->fatal('Envio de correo a' . $full_name . '');
            $GLOBALS['log']->fatal('>>>>' . $url . '<<<<');

            $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f"><b>' . $full_name . '</b>
      <br><br>Agradecemos de antemano su interés por colaborar con UNIFIN, para ello y como parte de nuestro proceso, le pedimos se complemente la información solicitada en el siguiente link.
      <br><br><a id="downloadErrors" href="' . $url . '/' . $full_name . '/' . $rfc . '/' . $idCuenta . '">Da Click Aquí</a>
      <br><br>Atentamente Unifin</font></p>
      <br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p> 
            
      <p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
      <p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
       Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema. 
       Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado. 
       No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS. 
       Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';


            $GLOBALS['log']->fatal($mailHTML);
            $GLOBALS['log']->fatal($correo);

            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject("Información sobre el registro en el Portal de Analízate");
            $body = trim($mailHTML);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($correo, $full_name));
            $result = $mailer->send();
        }
    }
}
