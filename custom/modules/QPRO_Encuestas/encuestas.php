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
					// Envía Correo vía Servicio de Sugar
					if($bean->assigned_user_id) 
					{
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
				if($beanGestion->tipo_envio == 2)
				{
					// Envía Correo vía Servicio de QP
					global $sugar_config;
					require_once 'modules/Configurator/Configurator.php';
					if($sugar_config['qp_peticiones'] <= $sugar_config['qp_max_peticiones'])
					{
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
						$configuratorObj = new Configurator();
						$configuratorObj->loadConfig();
						$configuratorObj->config['qp_peticiones'] = $sugar_config['qp_peticiones'] + 1;
						$configuratorObj->saveConfig();
					}
					else 
					{
						// Envía Correo de notificación del límite de peticiones
						global $app_list_strings;
						require_once 'include/SugarPHPMailer.php';
						require_once 'modules/Administration/Administration.php';
						$correos = $app_list_strings['correos_list'];
						$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que se ha alcanzado el límite máximo de peticiones hacia QuestionPro
							<br><br>Atentamente Unifin</font></p>
							<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
							<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
							Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
							Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
							No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
							Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
						$mailer = MailerFactory::getSystemDefaultMailer();
						$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
						$mailer->setSubject('Límite de peticiones a QuestionPro');
						$body = trim($mailHTML);
						$mailer->setHtmlBody($body);
						$mailer->clearRecipients();
						for ($i=1; $i <= count($correos); $i++) {
							$mailer->addRecipientsTo(new EmailIdentity($correos[$i]));
						}
						$result = $mailer->send();
						throw new SugarApiExceptionInvalidParameter("No se puede guardar la encuesta debido a que se ha alcanzado el límite de peticiones a QuestionPro");
					}
				}
			}
		}
	}
}