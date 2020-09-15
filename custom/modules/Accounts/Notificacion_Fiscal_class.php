<?php

class Notificacion_Fiscal_class
{
    public function notificacionF($bean, $event, $args)
    {
        $esproveedor = $bean->esproveedor_c;
        $tipo_registro_cuenta = $bean->tipo_registro_cuenta_c;
        $urlSugar = $GLOBALS['sugar_config']['site_url'] . '/#Accounts/';
        $idAccount = $bean->id;
        $linkReferencia = $urlSugar . $idAccount;

        $NombreProveedor = $bean->name;
        $rfc = $bean->rfc_c;
        $d = strtotime("now");
        $hoy = date("Y-m-d H:i:s", $d);
        if ($esproveedor == '1' || $tipo_registro_cuenta == '5') {
            $bean_user = BeanFactory::retrieveBean('Users', $bean->created_by, array('disable_row_level_security' => true));
            if (!empty($bean_user)) {
                $name_user = $bean_user->full_name;
            }

            $mailTo = $this->getEmailNotiFiscal();
            if (!empty($mailTo)) {
                $cuerpoCorreo = $this->estableceCuerpoNotificacion($name_user, $NombreProveedor, $rfc, $linkReferencia);

                /** Valida si esta actualizando o fue creación*/
                if (isset($args['isUpdate']) && $args['isUpdate'] == false) {

                    $emailOK = $this->sendEmailNotiFiscal($mailTo, $cuerpoCorreo);
                    if (empty($emailOK)) {
                        $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description)
				values ( uuid() , '" . $idAccount . "','" . $hoy . "','1','Valor utilizado para guardar registro de notificación en creación de nuevo proveedor.')";
                        $GLOBALS['db']->query($insert);
                    }

                } else {
                    $query = "select * from notification_accounts where account_id = '" . $idAccount . "' and  notification_type in ('1','2')";
                    $results = $GLOBALS['db']->query($query);
                    if ($results->num_rows == 0) {

                        $email_OK = $this->sendEmailNotiFiscal($mailTo, $cuerpoCorreo);
                        if (empty($email_OK)) {
                            $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description)
					values ( uuid() , '" . $idAccount . "','" . $hoy . "','2','Valor utilizado para guardar registro de notificación en actualización de cuenta como proveedor.')";
                            $GLOBALS['db']->query($insert);
                        }
                    }
                }
            }
        }
    }

    public function getEmailNotiFiscal()
    {
        $mailTo = [];
        $query1 = "SELECT nombre_completo_c, email_address FROM (SELECT A.id, B.nombre_completo_c FROM users A INNER JOIN users_cstm B   ON B.id_c=A.id  
 AND A.status='Active' AND A.deleted=0 AND B.notifica_fiscal_c = 1 ) USUARIOS
, (select erel.bean_id, email.email_address from email_addr_bean_rel erel join email_addresses email on
erel.bean_id = email.id where erel.bean_module = 'Users' and erel.primary_address = 1 AND erel.deleted = 0 AND email.deleted = 0 ) EMAILS
WHERE EMAILS.bean_id=USUARIOS.id";


        $results1 = $GLOBALS['db']->query($query1);

        while ($row = $GLOBALS['db']->fetchByAssoc($results1)) {
            $correo = $row['email_address'];
            $nombre = $row['nombre_completo_c'];
            if ($correo != "") {
                $mailTo ["$correo"] = $nombre;
            }
        }
        return $mailTo;
    }

    public function estableceCuerpoNotificacion($CreadoPor, $NombreProveedor, $rfc, $linkReferencia)
    {

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que la persona <b>' . $CreadoPor . '</b> 
		, acaba de dar de alta a un nuevo proveedor con nombre <b>' . $NombreProveedor . '</b> y su RFC es : <b>' . $rfc . '</b>.
		<br><br>Para ver el detalle del provedor de click aquí <a id="downloadErrors" href="' . $linkReferencia . '">Da Click Aquí</a>
		<br><br>Atentamente Unifin</font></p>
		<br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>

		<p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
		<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
		Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
		Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
		No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
		Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        return $mailHTML;

    }

    public function sendEmailNotiFiscal($mailTo, $bodyMail)
    {
        try {
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject("Nuevo Proveedor");
            $body = trim($bodyMail);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            foreach ($mailTo as $full_name => $email) {
                if ($email != "") {
                    $mailer->addRecipientsTo(new EmailIdentity($email, $full_name));
                }
            }
            $mailer->send();
        } catch (Exception $exception) {
            $GLOBALS['log']->fatal("Exception " . $exception);

        }
        return $exception;
    }
}

?>