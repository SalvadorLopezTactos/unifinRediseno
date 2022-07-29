<?php 

array_push($job_strings, 'NotiFiscalDiaria_job');
require_once 'include/SugarPHPMailer.php';
require_once 'include/utils/file_utils.php';
require_once 'include/SugarQuery/SugarQuery.php';

function NotiFiscalDiaria_job()
{
	//Inicia ejecución
	$GLOBALS['log']->fatal('Job NOtificación Fiscal: Inicia');
	//$urlSugar = $GLOBALS['sugar_config']['site_url'] . '/#Accounts/';
    //$linkReferencia = $urlSugar . $idAccount;
	$d = strtotime("now");
    $hoy = date("Y-m-d", $d);
	
	//FECHA ENVÍO,COMPRADOR,PROVEEDOR,RFC,FECHA RESPUESTA,RESULTADO
	//Fecha en la que se manda la notificación,
	//Para el escenario de crea alta proveedor enviar: Creado por. En caso de cotización de Precio enviar nombre Usuario uni2.
	//Nombre del Proveedor,RFC del proveedor,Enviar valor vacío,Enviar valor vacío.
	
	$query = "select * from notification_accounts where status = 1";
	//$GLOBALS['log']->fatal('query'.$query);
	$datos = [];	
	$result = $GLOBALS['db']->query($query);
	$allid ='';
	while($row = $GLOBALS['db']->fetchByAssoc($result) ){
		$var = [];
		$allid = "'".$row['id']."' , ".$allid;
		$account_id = $row['account_id'];
		$bean = BeanFactory::retrieveBean('Accounts', $account_id);
		$NombreProveedor = $bean->name;
		$rfc = $bean->rfc_c;
		//$GLOBALS['log']->fatal('NombreProveedor:'.$NombreProveedor);
		//$GLOBALS['log']->fatal('rfc:'.$rfc);
		//$GLOBALS['log']->fatal('allid:'.$allid);
		
		$notification_type = $row['notification_type'];
		$var['fecha_envio'] = $hoy;
		//$GLOBALS['log']->fatal('notification_type:'.$notification_type);
		$var['comprador'] = 'Creado por:'.$row['comprador'];
		$var['proveedor'] = $NombreProveedor;
		$var['rfc'] = $rfc;
		$var['fecha_respuesta'] = '';
		$var['resultado'] = '';
		
		array_push($datos, $var);
	}
	
	if(!empty ($datos)){
		//$GLOBALS['log']->fatal('datos',$datos);
		//print_r($datos,true);
		$site = $GLOBALS['sugar_config']['site_url'];
		$site =  substr($site, strrpos($site, "/"));
		//$GLOBALS['log']->fatal('site',$site);
		$name_file = "SOLICITUD_PROVEEDORES_SAT_{$hoy}_CONCENTRADO.xls";
		//$GLOBALS['log']->fatal('name_file',$name_file);
		
		$ruta_archivo = $_SERVER['DOCUMENT_ROOT'].$site."/upload/".$name_file;
		$ruta_archivo2 = "upload/".$name_file;
	
		date_default_timezone_set('America/Mexico_City');
		header('Content-Encoding: UTF-8');
		header('Content-type: text/xls; charset=UTF-8');
		header("content-type:application/vnd.ms-excel;charset=UTF-8");
		header("Content-Disposition: attachment; filename=\"$name_file\"");
		//header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Pragma: no-cache');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		//mb_convert_encoding($ruta_archivo, 'UTF-16LE', 'UTF-8');
		
		//$GLOBALS['log']->fatal('archivo',$ruta_archivo);
		$GLOBALS['log']->fatal('archivo',$ruta_archivo2);
		$file = fopen($ruta_archivo2, "w");
		fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		$flag = false;
		foreach($datos as $row) {
			if(!$flag) {
				// display field/column names as first row
				fputcsv($file, array_keys($row), ',', '"');
				$flag = true;
			}
			array_walk($row, __NAMESPACE__ );
			fputcsv($file, array_values($row), ',', '"');
		}
		fwrite($file, '-----------');
		fclose($file);
	
		$mailTo = [];
		$query1 = "SELECT A.id,A.first_name,A.last_name,E.email_address
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
 AND (A.status IS NULL OR A.status = 'Active')";
    
		//$GLOBALS['log']->fatal('query1'.$query1);
		$results1 = $GLOBALS['db']->query($query1);
		//$GLOBALS['log']->fatal('results1',$results1);
		while ($row = $GLOBALS['db']->fetchByAssoc($results1)) {
			$correo = $row['email_address'];
			$nombre = $row['nombre_completo_c'];
			if ($correo != "") {
				$mailTo ["$correo"] = $nombre; 
			}
		}
		
		//$GLOBALS['log']->fatal("mailTo",$mailTo);
		//$GLOBALS['log']->fatal("allid",$allid);
		if (!empty($mailTo) && $allid != '') {
			$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que se han dado de alta nuevos proveedores.
			<br>Para ver el detalle consulte el documento adjunto.
			<br><br>Atentamente Unifin</font></p>
			<br><p class="imagen"><img border="0" width="350" height="107" style="width:3.6458in;height:1.1145in" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
		
			<p class="MsoNormal"><span style="font-size:8.5pt;color:#757b80">______________________________<wbr>______________<u></u><u></u></span></p>
			<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
			Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
			Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
			No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
			Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/2019/av_menu.php" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=https://www.unifin.com.mx/2019/av_menu.php&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNHMJmAEhoNZUAyPWo2l0JoeRTWipg"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp; <br /> </span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener" data-saferedirecturl="https://www.google.com/url?q=http://www.unifin.com.mx/&amp;source=gmail&amp;ust=1582731642466000&amp;usg=AFQjCNF6DiYZ19MWEI49A8msTgXM9unJhQ"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a> </span><u></u><u></u></p>';
			
			$update = '';
			$allid = substr($allid, 0, -3); 
			//$GLOBALS['log']->fatal("inicio mail");
			try {
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject("SOLICITUD PROVEEDORES SAT {$hoy} CONCENTRADO");
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				foreach ($mailTo as  $email => $full_name) {
					if ($email != "") {
						$mailer->addRecipientsTo(new EmailIdentity($email, $full_name));
					}
				}
				
				$GLOBALS['log']->fatal("SE ADJUNTA ARCHIVO: ".$name_file);
				//$mailer->addAttachment(new \Attachment('upload/'.$name_file) , $name_file, 'Base64', "text/csv" );
				$mailer->addAttachment(new \Attachment('upload/'.$name_file) , $name_file );
				$mailer->send();
				
				$update = "UPDATE notification_accounts SET status = '2' WHERE ID IN ({$allid})";
				$GLOBALS['db']->query($update);
			} catch (Exception $exception) {
				$GLOBALS['log']->fatal("Exception " . $exception);
				
				$update = "UPDATE notification_accounts SET status = '3' WHERE ID IN ({$allid})";
				//$GLOBALS['log']->fatal("update " . $update);
				$GLOBALS['db']->query($update);
			}
		}
	}
	
	$GLOBALS['log']->fatal('Job NOtificación Fiscal: Termina');
	return true;
}

