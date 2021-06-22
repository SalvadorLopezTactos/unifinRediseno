<?php
array_push($job_strings, 'recuerda');

function recuerda()
{
	global $db;
	//Recuerda Bloqueo
	$notifica=0;
	$correos=array();
	$nombres=array();
	$query = "select c.id_c, c.user_id_c, c.user_id1_c from tct02_resumen_cstm c, accounts_cstm b, accounts a where a.id = b.id_c and b.id_c = c.id_c and b.tct_no_contactar_chk_c = 1 and c.bloqueo_cartera_c = 0 and a.deleted = 0 and c.user_id1_c is not null";
	$results = $db->query($query);
	while($row = $db->fetchByAssoc($results)) {
		$query0 = "select * from accounts_audit where field_name = 'tct_no_contactar_chk_c' and after_value_string = 1 and created_by = '{$row['user_id_c']}' and parent_id = '{$row['id_c']}' and date_created > '2021-06-15' and date_created < date_sub(now(), interval 7 day) order by date_created desc";
		$results0 = $db->query($query0);
		if($results0->num_rows > 0) {
			$valida = BeanFactory::retrieveBean('Users', $row['user_id1_c']);
			array_push($correos,$valida->email1);
			array_push($nombres,$valida->nombre_completo_c);
			$notifica=1;
		}
	}
	$query = "select b.id_c, b.user_id2_c, b.user_id3_c from tct02_resumen_cstm b, tct02_resumen a where a.id = b.id_c and b.bloqueo_credito_c = 1 and b.bloqueo2_c = 0 and a.deleted = 0 and b.user_id3_c is not null";
	$results = $db->query($query);
	while($row = $db->fetchByAssoc($results)) {
		$query0 = "select * from tct02_resumen_audit where field_name = 'bloqueo2_c' and after_value_string = 1 and created_by = '{$row['user_id2_c']}' and parent_id = '{$row['id_c']}' and date_created < date_sub(now(), interval 7 day) order by date_created desc";
		$results0 = $db->query($query0);
		if($results0->num_rows > 0) {
			$valida = BeanFactory::retrieveBean('Users', $row['user_id3_c']);
			array_push($correos,$valida->email1);
			array_push($nombres,$valida->nombre_completo_c);
			$notifica=1;
		}
	}
	$query = "select b.id_c, b.user_id4_c, b.user_id5_c from tct02_resumen_cstm b, tct02_resumen a where a.id = b.id_c and b.bloqueo_cumple_c = 1 and b.bloqueo3_c = 0 and a.deleted = 0 and b.user_id5_c is not null";
	$results = $db->query($query);
	while($row = $db->fetchByAssoc($results)) {
		$query0 = "select * from tct02_resumen_audit where field_name = 'bloqueo3_c' and after_value_string = 1 and created_by = '{$row['user_id4_c']}' and parent_id = '{$row['id_c']}' and date_created < date_sub(now(), interval 7 day) order by date_created desc";
		$results0 = $db->query($query0);
		if($results0->num_rows > 0) {
			$valida = BeanFactory::retrieveBean('Users', $row['user_id5_c']);
			array_push($correos,$valida->email1);
			array_push($nombres,$valida->nombre_completo_c);
			$notifica=1;
		}
	}
	require_once 'include/SugarPHPMailer.php';
	require_once 'modules/Administration/Administration.php';
	//Notifica Bloqueo
	if($notifica) {
		$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le recuerda que tiene al menos una cuenta pendiente de bloquear
		<br><br>Atentamente Unifin</font></p>
		<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
		<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
		Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
		Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
		No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
		Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
		$mailer = MailerFactory::getSystemDefaultMailer();
		$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
		$mailer->setSubject('Cuenta(s) pendiente(s) de bloquear');
		$body = trim($mailHTML);
		$mailer->setHtmlBody($body);
		$mailer->clearRecipients();
		for ($i=0; $i < count($correos); $i++) {
			$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
		}
		$result = $mailer->send();
	}
	//Recuerda Desbloqueo
	$notifica=0;
	$correos=array();
	$nombres=array();
	$query = "select c.id_c, c.user_id_c, c.user_id1_c from tct02_resumen_cstm c, accounts_cstm b, accounts a where a.id = b.id_c and b.id_c = c.id_c and b.tct_no_contactar_chk_c = 0 and c.bloqueo_cartera_c = 1 and a.deleted = 0 and c.user_id1_c is not null";
	$results = $db->query($query);
	while($row = $db->fetchByAssoc($results)) {
		$query0 = "select * from accounts_audit where field_name = 'tct_no_contactar_chk_c' and after_value_string = 0 and created_by = '{$row['user_id_c']}' and parent_id = '{$row['id_c']}' and date_created > '2021-06-15' and date_created < date_sub(now(), interval 7 day) order by date_created desc";
		$results0 = $db->query($query0);
		if($results0->num_rows > 0) {
			$valida = BeanFactory::retrieveBean('Users', $row['user_id1_c']);
			array_push($correos,$valida->email1);
			array_push($nombres,$valida->nombre_completo_c);
			$notifica=1;
		}
	}
	$query = "select b.id_c, b.user_id2_c, b.user_id3_c from tct02_resumen_cstm b, tct02_resumen a where a.id = b.id_c and b.bloqueo_credito_c = 0 and b.bloqueo2_c = 1 and a.deleted = 0 and b.user_id3_c is not null";
	$results = $db->query($query);
	while($row = $db->fetchByAssoc($results)) {
		$query0 = "select * from tct02_resumen_audit where field_name = 'bloqueo2_c' and after_value_string = 0 and created_by = '{$row['user_id2_c']}' and parent_id = '{$row['id_c']}' and date_created < date_sub(now(), interval 7 day) order by date_created desc";
		$results0 = $db->query($query0);
		if($results0->num_rows > 0) {
			$valida = BeanFactory::retrieveBean('Users', $row['user_id3_c']);
			array_push($correos,$valida->email1);
			array_push($nombres,$valida->nombre_completo_c);
			$notifica=1;
		}
	}
	$query = "select b.id_c, b.user_id4_c, b.user_id5_c from tct02_resumen_cstm b, tct02_resumen a where a.id = b.id_c and b.bloqueo_cumple_c = 0 and b.bloqueo3_c = 1 and a.deleted = 0 and b.user_id5_c is not null";
	$results = $db->query($query);
	while($row = $db->fetchByAssoc($results)) {
		$query0 = "select * from tct02_resumen_audit where field_name = 'bloqueo3_c' and after_value_string = 0 and created_by = '{$row['user_id4_c']}' and parent_id = '{$row['id_c']}' and date_created < date_sub(now(), interval 7 day) order by date_created desc";
		$results0 = $db->query($query0);
		if($results0->num_rows > 0) {
			$valida = BeanFactory::retrieveBean('Users', $row['user_id5_c']);
			array_push($correos,$valida->email1);
			array_push($nombres,$valida->nombre_completo_c);
			$notifica=1;
		}
	}
	//Notifica Desbloqueo
	if($notifica) {
		$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le recuerda que tiene al menos una cuenta pendiente de desbloquear
		<br><br>Atentamente Unifin</font></p>
		<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
		<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
		Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
		Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
		No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
		Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
		$mailer = MailerFactory::getSystemDefaultMailer();
		$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
		$mailer->setSubject('Cuenta(s) pendiente(s) de desbloquear');
		$body = trim($mailHTML);
		$mailer->setHtmlBody($body);
		$mailer->clearRecipients();
		for ($i=0; $i < count($correos); $i++) {
			$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
		}
		$result = $mailer->send();
	}
    return true;
}