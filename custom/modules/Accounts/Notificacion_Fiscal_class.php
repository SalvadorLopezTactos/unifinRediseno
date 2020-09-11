<?php

class Notificacion_Fiscal_class
{
    public function notificacionF($bean, $event, $args)
    {
        //esproveedor_c = 1  //tipo_registro_cuenta_c = 5

        $esproveedor = $bean->esproveedor_c;
        $tipo_registro_cuenta = $bean->tipo_registro_cuenta_c;

        $urlSugar = $GLOBALS['sugar_config']['site_url'] . '/#Accounts/';
        $idAccount = $bean->id;
        $linkReferencia = $urlSugar . $idAccount;

        //$CreadoPor , $NombreProveedor , $rfc
        $CreadoPor = $bean->created_by;
        $NombreProveedor = $bean->name;
        $rfc = $bean->rfc_c;

        $creado = BeanFactory::retrieveBean('Users', $CreadoPor,array('disable_row_level_security' => true));
        if (!empty($creado)) {
            $nombrecreado = $creado->full_name;
        }
        $enviocorreo = 0;
        // $array = $GLOBALS['app_list_strings']['tipo_registro_cuenta_list'];
        //$GLOBALS['log']->fatal('$esproveedor' . $esproveedor . '- tipo_registro_cuenta' . $tipo_registro_cuenta);
        if ($esproveedor == '1' || $tipo_registro_cuenta == '5') {

            $d = strtotime("now");
            $hoy = date("Y-m-d H:i:s", $d);
            //$GLOBALS['log']->fatal('$isUpdate' . $args['isUpdate']);
            //$GLOBALS['log']->fatal('$hoy' . $hoy);
            if (isset($args['isUpdate']) && $args['isUpdate'] == false) {
                //new record
                $enviocorreo = 1;
                $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description)
				values ( uuid() , '" . $idAccount . "','" . $hoy . "','1','Valor utilizado para guardar registro de notificación en creación de nuevo proveedor.')";
                $GLOBALS['db']->query($insert);
            } else {
                //existing record
                $query = "select * from notification_accounts where account_id = '" . $idAccount . "' and  notification_type in ('1','2')";
                //$GLOBALS['log']->fatal('query - ' . $query);
                $results = $GLOBALS['db']->query($query);
                
				if ($results->num_rows < 1) {
                    $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description)
					values ( uuid() , '" . $idAccount . "','" . $hoy . "','2','Valor utilizado para guardar registro de notificación en actualización de cuenta como proveedor.')";
                    $GLOBALS['db']->query($insert);
					$enviocorreo = 1;
                }
            }
            //$GLOBALS['log']->fatal('enviocorreo ' . $enviocorreo);
            if ($enviocorreo == 1) {
				$cuerpoCorreo = $this->estableceCuerpoNotificacion($nombrecreado, $NombreProveedor, $rfc, $linkReferencia);
                        
                $query1 = "SELECT nombre_completo_c, email_address FROM (SELECT A.id, B.nombre_completo_c FROM users A INNER JOIN users_cstm B   ON B.id_c=A.id  
 AND A.employee_status = 'Active' and B.notifica_fiscal_c = 1 AND (A.status IS NULL OR A.status = 'Active') AND A.deleted=0 AND B.notifica_fiscal_c = 1 ) USUARIOS
, (select erel.bean_id, email.email_address from email_addr_bean_rel erel join email_addresses email on
erel.email_address_id = email.id where erel.bean_module = 'Users' and erel.primary_address = 1 AND erel.deleted = 0 AND email.deleted = 0 ) EMAILS
WHERE EMAILS.bean_id=USUARIOS.id";
				//$GLOBALS['log']->fatal('query ' . $query1);
                $results1 = $GLOBALS['db']->query($query1);
				try {
					$result = "";
					$mailer = MailerFactory::getSystemDefaultMailer();
					$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
					$mailer->setSubject("Nuevo Proveedor");
					$body = trim($cuerpoCorreo);
					$mailer->setHtmlBody($body);
					$mailer->clearRecipients();
					
					while ($row = $GLOBALS['db']->fetchByAssoc($results1)) {
						$correo = $row['email_address'];
						$nombre = $row['nombre_completo_c'];
						
						if ($correo != "") {
							$mailer->addRecipientsTo(new EmailIdentity($correo, $nombre)); 
							$GLOBALS['log']->fatal('Envío de correo proveedor '.$nombre.' - '.$correo);
						}else {
							$GLOBALS['log']->fatal($nombre . " NO TIENE EMAIL");
						}						
					}
					$mailer->send();
	
	
				} catch (Exception $e) {
					//  $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email " . $correo);
					$GLOBALS['log']->fatal("Exception " . $e);
				}
            }
        }
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

}

?>