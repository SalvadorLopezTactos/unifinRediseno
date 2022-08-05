<?php
array_push($job_strings, 'nocontactar');

function nocontactar()
{
    require_once 'include/SugarQuery/SugarQuery.php';
 	$beanQuery = BeanFactory::newBean('Documents');
	$sugarQuery = new SugarQuery();
	$sugarQuery->select(array('id', 'document_name', 'status_id', 'assigned_user_id'));
	$sugarQuery->from($beanQuery);
	$sugarQuery->where()->equals('status_id','Pending');
	$sugarQuery->where()->equals('template_type','nocontactar');
	$result = $sugarQuery->execute();
	$count = count($result);
	for($current=0; $current < $count; $current++)
	{
		require_once 'include/SugarPHPMailer.php';
		require_once 'include/utils/file_utils.php';
		require_once 'include/utils/sugar_file_utils.php';
		require_once 'modules/Administration/Administration.php';
		require_once 'custom/clients/base/api/CuentasNoContactar.php';
		$beanDoc = BeanFactory::retrieveBean('Documents', $result[$current]['id']);
		$beanDoc->status_id = 'Active';
		$beanDoc->save();
		$nombre = $result[$current]['document_name'];
		$file = 'upload/'.$nombre;
		$contenido = sugar_file_get_contents($file);
		$arr = explode("\n", $contenido);
        $total = 0;
        $actualizados = [];
		$no_actualizados = [];
		foreach ($arr as $key => $value) {
			$row = explode(",", $value);
			$idCuenta = $row[0];
			if($idCuenta != "" && $idCuenta != "idCuenta"){
				$params = [];
				$params['condicion'] = $row[1];
				$params['razon'] = $row[2];
				$params['motivo'] = $row[3];
				$params['detalle'] = $row[4];
				$params['ingesta'] = $row[5];
				$params['valida'] = $row[6];
				$cuentas = array();
				array_push($cuentas, $idCuenta);
				$args = [];
				$args['data']=[];
				$args['data']['cuentas'] = $cuentas;
				$args['data']['parame'] = $params;
				$args['data']['selected'] = $row[7];
				$callApi = new CuentasNoContactar();
				$respuesta = $callApi->updateCuentasNoContactar('', $args);
				if($respuesta[actualizados][0]) array_push($actualizados, $respuesta[actualizados][0]);
				if($respuesta[no_actualizados][0]) array_push($no_actualizados, $respuesta[no_actualizados][0]);
				$total = $total + 1;
			}
		}
		$fecha = date("YmdHis");
		$nombres = substr($nombre, 14, -4);
		$url = $GLOBALS['sugar_config']['site_url'];
		$archivo = 'custom/errores_reasignacion/'.$nombres.'_'.$fecha.'.txt';
		$fichero = $url.'/custom/errores_reasignacion/'.$nombres.'_'.$fecha.'.txt';
		$texto_archivo="ACTUALIZADOS:\n";
		for ($i=0;$i<count($actualizados);$i++){
			$texto_archivo.=$actualizados[$i]."\n";
		}
		$texto_archivo.="\nNO ACTUALIZADOS:\n";
		for ($i=0;$i<count($no_actualizados);$i++){
			$texto_archivo.=$no_actualizados[$i]."\n";
		}
		file_put_contents($archivo, $texto_archivo, FILE_APPEND | LOCK_EX);
		$usuario = BeanFactory::retrieveBean('Users', $result[$current]['assigned_user_id']);
		$correo = $usuario->email1;
		$user = $usuario->nombre_completo_c;
		$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Hola <b>'.$user.'</b>
		<br><br>A continuación se muestra el resultado de la actualización masiva de cuentas no contactar del archivo cargado '.$nombres.'.csv:
		<br><br>Actualizados: '.count($actualizados).'
		<br>No actualizados: '.count($no_actualizados).'
		<br>Total: '.$total.'
		<br><br>En la siguiente ruta podrá descargar el archivo con el detalle de carga de la actualización masiva de cuentas: <a id="downloadErrors" href="'.$fichero.'" download="'.$fichero.'">Descargar</a>
		<br><br>Saludos.
		<br><br>Atentamente Unifin</font></p>
		<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
		<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
		Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
		Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
		No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
		Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';		
		$mailer = MailerFactory::getSystemDefaultMailer();
		$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
		$mailer->setSubject("Resultado de la actualización masiva de cuentas no contactar");
		$body = trim($mailHTML);
		$mailer->setHtmlBody($body);
		$mailer->clearRecipients();
		$mailer->addRecipientsTo(new EmailIdentity($correo, $usuario->first_name . ' ' . $usuario->last_name));
		$result = $mailer->send();
	}
	return true;
}