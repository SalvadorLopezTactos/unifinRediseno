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
			$nombre = $result[$current]['document_name'];
			$file = 'upload/'.$nombre;
			$contenido = sugar_file_get_contents($file);
			$arr = explode("\n", $contenido);
			$args = [];
			$args['data']=[];
			$args['data']['cuentas'] = $arr;
			$callApi = new CuentasNoContactar();
			$respuesta = $callApi->updateCuentasNoContactar('', $args);
      $total = count($respuesta[actualizados])+count($respuesta[no_actualizados]);
      $fecha = date("YmdHis");
      $nombres = substr($nombre, 14, -4);
      $url = $GLOBALS['sugar_config']['site_url'];
      $archivo = 'custom/errores_reasignacion/'.$nombres.'_'.$fecha.'.txt';
      $fichero = $url.'/custom/errores_reasignacion/'.$nombres.'_'.$fecha.'.txt';
      $texto_archivo="ACTUALIZADOS:\n";
      for ($i=0;$i<count($respuesta[actualizados]);$i++){
        $texto_archivo.=$respuesta[actualizados][$i]."\n";
      }
      $texto_archivo.="\nNO ACTUALIZADOS:\n";
      for ($i=0;$i<count($respuesta[no_actualizados]);$i++){
        $texto_archivo.=$respuesta[no_actualizados][$i]."\n";
      }      
      file_put_contents($archivo, $texto_archivo, FILE_APPEND | LOCK_EX);
			$beanDoc = BeanFactory::retrieveBean('Documents', $result[$current]['id']);
			$beanDoc->status_id = 'Active';
			$beanDoc->save();
			$usuario = BeanFactory::retrieveBean('Users', $result[$current]['assigned_user_id']);
			$correo = $usuario->email1;
      $user = $usuario->nombre_completo_c;
      $mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Hola <b>'.$user.'</b>
      <br><br>A continuación se muestra el resultado de la actualización masiva de cuentas no contactar del archivo cargado '.$nombre.':
      <br><br>Actualizados: '.count($respuesta[actualizados]).'
      <br>No actualizados: '.count($respuesta[no_actualizados]).'
      <br>Total: '.$total.'
      <br><br>En la siguiente ruta podrá descargar el archivo con el detalle de carga de la actualización masiva de cuentas: <a id="downloadErrors" href="'.$fichero.'" download="'.$fichero.'">Descargar</a>
      <br><br>Saludos.</font></p>';
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