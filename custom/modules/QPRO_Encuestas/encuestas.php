<?php
/*
 * Created by Tactos
 * Email: eduardo.carrasco@tactos.com.mx
 * Date: 26/04/2022
*/

class encuestas
{
    public function encuestas($bean = null, $event = null, $args = null)
    {
        // Guarda related_id
        if($bean->related_module == "Accounts") $bean->related_id = $bean->account_id_c;
		if($bean->related_module == "Leads") $bean->related_id = $bean->lead_id_c;
		if($bean->related_module == "Users") $bean->related_id = $bean->user_id_c;
        if($bean->fetched_row['id'] != $bean->id)
        {
			// Recupera datos de Gestión de Encuentas
			$idGestion = $bean->qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida;
			$beanGestion = BeanFactory::getBean('QPRO_Gestion_Encuestas', $idGestion, array('disable_row_level_security' => true));
			if($beanGestion->name != "Calidad de cita")
			{
				// Obtiene datos para el correo
				if($bean->related_module == "Accounts") $beanRel = BeanFactory::getBean('Accounts', $bean->account_id_c, array('disable_row_level_security' => true));
				if($bean->related_module == "Leads") $beanRel = BeanFactory::getBean('Leads', $bean->lead_id_c, array('disable_row_level_security' => true));
				if($bean->related_module == "Users") $beanRel = BeanFactory::getBean('Users', $bean->user_id_c, array('disable_row_level_security' => true));
				$email = $beanRel->email1;
				if($beanGestion->tipo_envio == 1)
				{
					// Envía Correo vía Servivio de Sugar
					if($bean->assigned_user_id) {
						$beanUsr = BeanFactory::getBean('Users', $bean->assigned_user_id, array('disable_row_level_security' => true));
						$usuario = $beanUsr->name;
					}
					$url = $beanGestion->url."?idpersona=".$bean->related_id."&idencuesta=".$bean->id;
					$nombre = $beanRel->name;
					if($beanGestion->name == "Cita no realizada") $nombre = $bean->name;
					$fecha = $bean->fecha_envio;
					$template_name = $beanGestion->plantilla;
					// Ejecuta envío de correo electrónico
					require_once("include/SugarPHPMailer.php");
					require_once("modules/EmailTemplates/EmailTemplate.php");
					require_once("modules/Administration/Administration.php");
					$emailtemplate = new EmailTemplate();
					$emailtemplate->retrieve_by_string_fields(array('name' => $template_name,'type'=>'email'));
					$emailtemplate->subject = $emailtemplate->subject;
					$body_html = $emailtemplate->body_html;
					$body_html = str_replace('account_name', $nombre, $body_html);
					$body_html = str_replace('user_name', $usuario, $body_html);
					$body_html = str_replace('fecha_envio', $fecha, $body_html);
					$emailtemplate->body_html = str_replace('url_encuesta', $url, $body_html);
					$mailer = MailerFactory::getSystemDefaultMailer();
					$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
					$mailer->setSubject($emailtemplate->subject);
					$body = trim($emailtemplate->body_html);
					$mailer->setHtmlBody($body);
					$mailer->clearRecipients();
					$mailer->addRecipientsTo(new EmailIdentity($email, $nombre));
					$result = $mailer->send();
				}
				else
				{
					// Envía Correo vía Servivio de QP
					global $sugar_config;
					$curl = curl_init();
					$api = $sugar_config['qp_api'];
					$url = $sugar_config['qpro'].$beanGestion->encuesta_id.'/batches?apiKey='.$api;
					$arreglo = array(
						"emails" => array($email.",".$bean->related_id.",".$bean->id),
						"templateID" => $beanGestion->template_id,
						"mode" => 2
					);
					$content = json_encode($arreglo);
					curl_setopt_array($curl, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_HTTPHEADER => array("Content-type: application/json"),
						CURLOPT_POSTFIELDS => $content,
					));
					$response = curl_exec($curl);
					$response = json_decode($response);
					curl_close($curl);
				}
			}
		}
	}
}