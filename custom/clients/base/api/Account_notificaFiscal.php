<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 8/09/20
 * Time: 12:48 PM
 */


class Account_notificaFiscal extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'existsAccounts' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('notificaFiscal'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'function_notificaFiscal',
                //short help string to be displayed in the help documentation
                'shortHelp' => ' Notificación de cotización de precio, UNI2 ',
                //long help to be displayed in the help documentation
                'longHelp' => 'Validará que no se haya generado una notificación durante los últimos 3 meses,
                 de ser así se deberá notificar al área fiscal. En caso contrario, no se ejecutará el envío de la notificación',
            )

        );
    }
    // Para la notificación de cotización de precio,
    // uni2 deberá ejecutar la petición a CRM y dentro de
    // CRM se validará que no se haya generado una notificación durante
    // los últimos 3 meses, de ser así se deberá notificar al área fiscal.
    // En caso contrario, no se ejecutará el envío de la notificación.


    public function function_notificaFiscal($api, $args)
    {
        $idCuenta = $args['idCuenta'];
        $nombreUsuario = $args['nombreUsuario'];
        $d = strtotime("now");
        $hoy = date("Y-m-d H:i:s", $d);
        if (!empty($idCuenta) && !empty($nombreUsuario)) {
            $beanAccount = BeanFactory::retrieveBean('Accounts', $idCuenta, array('disable_row_level_security' => true));

            if (!empty($beanAccount) && $beanAccount != null) {
                $mailTo = $this->getmailTo();

                $noti_accounts = "SELECT * FROM notification_accounts
WHERE account_id = '{$idCuenta}'
      AND notification_type = '3'
      AND date_entered > DATE_SUB(now(), INTERVAL 3 MONTH)
ORDER BY date_entered DESC";

                $results = $GLOBALS['db']->query($noti_accounts);

                $row = $GLOBALS['db']->fetchByAssoc($results);
                
				$d = strtotime( $row['date_entered'] );
				$fechaEnvio = date("Y-m-d", $d);
                
				$responses = [];

                if ($results->num_rows == 0) {
                    $enviado = $this->sendmailTo($nombreUsuario, $beanAccount->name, $beanAccount->rfc_c, $idCuenta, $mailTo);
                    //$GLOBALS['log']->fatal('envio de correo - ' . $enviado);

                    if ($enviado == "") {
                        $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description)
					values ( uuid() , '" . $idCuenta . "','" . $hoy . "','3','Petición de UNI2')";
                        try {
                            $GLOBALS['db']->query($insert);
                        } catch (Exception $ex) {
                            $GLOBALS['log']->fatal("Exception " . $ex);
                        }
                        if ($ex == "") {
                            $responses = array("code" => "200", "status" => "success", "description" => "Notificación enviada exitosamente al área fiscal.");
                        } else {
                            $responses = array("code" => "400", "status" => "error", "description" => $ex);
                        }
                    } else {
                        $responses = array("code" => "400", "status" => "error", "description" => $enviado);
                    }

                } else {
                    $responses = array("code" => "200", "status" => "success", "description" => "La última actualización de este proveedor fue el $fechaEnvio. Por lo tanto no se notificó al área fiscal ");
                }

            } else {
                $responses = array("code" => "400", "status" => "error", "description" => "No existe la cuenta");
            }
        } else {
            $responses = array("code" => "400", "status" => "error", "description" => "Información incompleta");
        }
        return $responses;
    }

    public function getmailTo()
    {
        $query = "SELECT A.id,A.first_name,A.last_name,E.email_address
FROM users A
  INNER JOIN users_cstm B
    ON B.id_c = A.id
  INNER JOIN email_addr_bean_rel rel
    ON rel.bean_id = B.id_c
       AND rel.bean_module = 'Users'
       AND rel.deleted = 0
  INNER JOIN email_addresses E
    ON E.id = rel.email_address_id
  AND E.deleted=0
WHERE B.notifica_fiscal_c = 1 AND
 A.employee_status = 'Active' AND A.deleted = 0
 AND (A.status IS NULL OR A.status = 'Active') ";
        $results = $GLOBALS['db']->query($query);
        $mailTo = [];
		
        while ($row = $GLOBALS['db']->fetchByAssoc($results)) {
            
			//$GLOBALS['log']->fatal('nombre' .  $row['first_name'] . ' - correo ' . $row['email_address']);
			$full_name =$row['first_name'] . " " . $row['last_name'];
            $mailTo["{$full_name}"] = $row['email_address'];
        }
		
		return $mailTo;
    }

    public function sendmailTo($nameUser, $nameAccount, $rfc, $idAccount, $mailTo)
    {
        $urlSugar = $GLOBALS['sugar_config']['site_url'] . '/#Accounts/';
        $linkReferencia = $urlSugar . $idAccount;

        $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que el usuario <b>' . $nameUser . '</b> 
		, relaciono a una cotización de precio al Proveedor <b>' . $nameAccount . '</b> , que tiene RFC: <b>' . $rfc . '</b>.
		<br><br>Para ver el detalle del proveedor dé <a id="downloadErrors" href="' . $linkReferencia . '">click aquí</a>
		<br><br>Atentamente Unifin</font></p>
		<br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>

		<p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
		<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
		Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
		Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
		No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
		Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';

        if (count($mailTo) > 0) {
            try {
                $result = "";
                $mailer = MailerFactory::getSystemDefaultMailer();
                $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
                $mailer->setSubject("Nueva cotización de precio asociada a un Proveedor");
                $body = trim($mailHTML);
                $mailer->setHtmlBody($body);
                $mailer->clearRecipients();
				//$GLOBALS['log']->fatal('Para enviar',print_r($mailTo,true));
                foreach ($mailTo as $full_name => $email) {
					//$GLOBALS['log']->fatal('dentro del for '.$full_name.' - '.$email);
                    if ($email != "") {
                        $mailer->addRecipientsTo(new EmailIdentity($email, $full_name));                        
                    }
                }
				$mailer->send();


            } catch (Exception $e) {
                //  $GLOBALS['log']->fatal("Exception: No se ha podido enviar correo al email " . $correo);
                $GLOBALS['log']->fatal("Exception " . $e);
            }
        }

        return $e;
    }


}