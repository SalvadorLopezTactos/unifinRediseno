<?php
/**
 * @author Tactos
 * Date: 06/06/202
 **/
class reunion_participantes
{
	public function reunion_participantes($bean = null, $event = null, $args = null)
    {
		global $current_user;
		if($bean->tct_conferencia_chk_c && $current_user->lenia_c) {
			$nueva = 0;
			$lenia = 0;
			$guest = array();
			$advisor = array();
			$correos = array();
			if($bean->parent_id) {
				$beanAccount = BeanFactory::getBean('Accounts', $bean->parent_id, array('disable_row_level_security' => true));
				$cuenta_name = $beanAccount->name;
			}
			$objParticipantes = $bean->reunion_participantes;
			$objArrParticipnates = $objParticipantes['participantes'];
			if ($objArrParticipnates != "" && isset($objArrParticipnates))
			{
				for ($j = 0; $j < count($objArrParticipnates); $j++) {
					if ($objArrParticipnates[$j]['origen'] == "N") {
					  // Crea cuenta
					  $beanCuentas = BeanFactory::newBean("Accounts");
					  $beanCuentas->primernombre_c = $objArrParticipnates[$j]['nombres'];
					  $beanCuentas->apellidopaterno_c = $objArrParticipnates[$j]['apaterno'];
					  $beanCuentas->apellidomaterno_c = $objArrParticipnates[$j]['amaterno'];
					  $beanCuentas->phone_office = $objArrParticipnates[$j]['telefono'];
					  $beanCuentas->email1 = $objArrParticipnates[$j]['correo'];
					  $beanCuentas->tipo_registro_cuenta_c = "4";
					  $beanCuentas->clean_name= $objArrParticipnates[$j]['clean_name'];
					  try {
						  $beanCuentas->save();
						  $cuenta = $beanCuentas->id;
						  $objArrParticipnates[$j]['id']=$beanCuentas->id;
						  $nueva = 1;
					  } catch (Exception $e) {
						  $GLOBALS['log']->fatal("Error: ".$e);
					  }
					}
					if ($objArrParticipnates[$j]['crea']) {
					  // Guarda registro de participante
					  $lenia = 1;
					  $beanParticipante = BeanFactory::newBean("minut_Participantes");
					  $beanParticipante->name = $objArrParticipnates[$j]['nombres'];
					  $beanParticipante->tct_apellido_paterno_c = $objArrParticipnates[$j]['apaterno'];
					  $beanParticipante->tct_apellido_materno_c = $objArrParticipnates[$j]['amaterno'];
					  $beanParticipante->tct_nombre_completo_c = $objArrParticipnates[$j]['nombres'] . " " . $objArrParticipnates[$j]['apaterno'] . " " . $objArrParticipnates[$j]['amaterno'];
					  $beanParticipante->tct_correo_c = $objArrParticipnates[$j]['correo'];
					  $beanParticipante->tct_telefono_c = $objArrParticipnates[$j]['telefono'];
					  $beanParticipante->tct_asistencia_c = $objArrParticipnates[$j]['asistencia'];
					  $beanParticipante->tct_tipo_registro_c = $objArrParticipnates[$j]['tipo_contacto'];
					  $beanParticipante->tct_id_registro_c = $objArrParticipnates[$j]['id'];
					  $beanParticipante->invitar_c = $objArrParticipnates[$j]['activo'];
					  $beanParticipante->cuenta_c = $objArrParticipnates[$j]['cuenta'];
					  $beanParticipante->meetings_minut_participantes_1meetings_ida = $bean->id;
					  $beanParticipante->description = $objArrParticipnates[$j]['unifin'];
					  $beanParticipante->save();
					  if($objArrParticipnates[$j]['activo']) {
						if($objArrParticipnates[$j]['host']) {
							$host = [
								"first_name" => $beanParticipante->name,
								"father_last_name" => $beanParticipante->tct_apellido_paterno_c,
								"mother_last_name" => $beanParticipante->tct_apellido_materno_c,
								"full_name" => $beanParticipante->tct_nombre_completo_c,
								"email" => $beanParticipante->tct_correo_c,
								"crm_id" => $beanParticipante->id,
							];
							array_push($advisor,$host);
							$organizador = $beanParticipante->id;
						}
						else {
							$participante = [
								"first_name" => $beanParticipante->name,
								"father_last_name" => $beanParticipante->tct_apellido_paterno_c,
								"mother_last_name" => $beanParticipante->tct_apellido_materno_c,
								"full_name" => $beanParticipante->tct_nombre_completo_c,
								"email" => $beanParticipante->tct_correo_c,
								"crm_id" => $beanParticipante->id,
							];
							array_push($guest,$participante);
						}
						$correo = ["id" => $beanParticipante->id, "name" => $beanParticipante->tct_nombre_completo_c, "mail" => $beanParticipante->tct_correo_c];
						array_push($correos,$correo);
					  }
					}
					else {
					  if($objArrParticipnates[$j]['activo']) {
						if($objArrParticipnates[$j]['unifin']) {
						    $host1 = [
								"first_name" => $objArrParticipnates[$j]['nombres'],
								"father_last_name" => $objArrParticipnates[$j]['apaterno'],
								"mother_last_name" => $objArrParticipnates[$j]['amaterno'],
								"full_name" => $objArrParticipnates[$j]['nombres'] . " " . $objArrParticipnates[$j]['apaterno'] . " " . $objArrParticipnates[$j]['amaterno'],
								"email" => $objArrParticipnates[$j]['correo'],
								"crm_id" => $objArrParticipnates[$j]['id'],
							];
							array_push($advisor,$host1);
							$organizador = $objArrParticipnates[$j]['id'];
						}
						else {
							$participante1 = [
								"first_name" => $objArrParticipnates[$j]['nombres'],
								"father_last_name" => $objArrParticipnates[$j]['apaterno'],
								"mother_last_name" => $objArrParticipnates[$j]['amaterno'],
								"full_name" => $objArrParticipnates[$j]['nombres'] . " " . $objArrParticipnates[$j]['apaterno'] . " " . $objArrParticipnates[$j]['amaterno'],
								"email" => $objArrParticipnates[$j]['correo'],
								"crm_id" => $objArrParticipnates[$j]['id'],
							];
							array_push($guest,$participante1);
						}
						if($objParticipantes['actualiza'] || $bean->status == 'Not Held') {
							$correo = ["id" => $objArrParticipnates[$j]['id'], "name" => $objArrParticipnates[$j]['nombres'] . " " . $objArrParticipnates[$j]['apaterno'] . " " . $objArrParticipnates[$j]['amaterno'], "mail" => $objArrParticipnates[$j]['correo']];
							array_push($correos,$correo);
						}
						else {
							if($objArrParticipnates[$j]['actualiza']) {
								$correo = ["id" => $objArrParticipnates[$j]['id'], "name" => $objArrParticipnates[$j]['nombres'] . " " . $objArrParticipnates[$j]['apaterno'] . " " . $objArrParticipnates[$j]['amaterno'], "mail" => $objArrParticipnates[$j]['correo']];
								array_push($correos,$correo);
							}
						}
					  }
					  //Actualiza Participante
					  $beanParticipa = BeanFactory::getBean('minut_Participantes', $objArrParticipnates[$j]['id'], array('disable_row_level_security' => true));
					  $beanParticipa->invitar_c = 1;
					  if(!$objArrParticipnates[$j]['activo']) $beanParticipa->invitar_c = 0;
					  $beanParticipa->save();					  
					}
					// Busca relación
					if($objArrParticipnates[$j]['origen'] == "E")
					{
						$conta = 0;
						$beanPersona = BeanFactory::getBean('Accounts', $bean->parent_id);
						$beanPersona->load_relationship('rel_relaciones_accounts_1');
						$relatedRelaciones = $beanPersona->rel_relaciones_accounts_1->getBeans();
						$totalRelaciones = count($relatedRelaciones);
						if($totalRelaciones > 0)
						{
						  foreach($relatedRelaciones as $relacion)
						  {
							if($relacion->account_id1_c == $objArrParticipnates[$j]['id'])
							{
							  if(strpos($relacion->relaciones_activas, "Contacto") == TRUE)
							  {
								if($relacion->tipodecontacto != $objArrParticipnates[$j]['tipo_contacto'])
								{
								  $beanRelated = BeanFactory::getBean('Rel_Relaciones', $relacion->id);
								  $beanRelated->tipodecontacto = $objArrParticipnates[$j]['tipo_contacto'];
								  $beanRelated->save();
								}
							  }
							  else
							  {
								$beanRelated = BeanFactory::getBean('Rel_Relaciones', $relacion->id);
								$beanRelated->relaciones_activas = $beanRelated->relaciones_activas.',^Contacto^';
								$beanRelated->tipodecontacto = $objArrParticipnates[$j]['tipo_contacto'];
								$beanRelated->save();
							  }
							}
							else
							{
							  $conta = $conta + 1;
							}
						  }
						  if($conta == $totalRelaciones)
						  {
							$nueva = 1;
							$cuenta = $objArrParticipnates[$j]['id'];
						  }
						}
						else
						{
						  $nueva = 1;
						  $cuenta = $objArrParticipnates[$j]['id'];
						}
					}
					if($nueva)
					{
						// Genera relación
						$beanRelacion = BeanFactory::newBean("Rel_Relaciones");
						$beanRelacion->tipodecontacto = $objArrParticipnates[$j]['tipo_contacto'];
						$beanRelacion->relaciones_activas = "Contacto";
						$beanRelacion->rel_relaciones_accounts_1accounts_ida = $bean->parent_id;
						$beanRelacion->account_id1_c = $cuenta;
						$beanRelacion->rel_relaciones_accountsaccounts_ida = $beanRelacion->rel_relaciones_accounts_1accounts_ida;
						try {
							$beanRelacion->save();
							$nueva = 0;
						} catch (Exception $e) {
							$GLOBALS['log']->fatal("Error: ".$e);
						}
					}
					// Actualiza telefono y correo de cuentas existentes
					if($objArrParticipnates[$j]['id'] && $objArrParticipnates[$j]['origen']=="C")
					{
						$beanCuenta = BeanFactory::getBean('Accounts', $objArrParticipnates[$j]['id']);
						$beanCuenta->phone_office = (trim($objArrParticipnates[$j]['telefono'])!="") ? $objArrParticipnates[$j]['telefono'] : $beanCuenta->phone_office;
						$beanCuenta->email1 = (trim($objArrParticipnates[$j]['correo'])!="") ? $objArrParticipnates[$j]['correo'] : $beanCuenta->email1;
						$beanCuenta->save();
					}
				}
				if($objParticipantes['actualiza']) $lenia = 1;
			}
			else
			{
				// Entra cuando se ejectua el trabajo de error lenia
				$queryRecord = "SELECT T3.id,T3.name,T3.description,T3.tct_apellido_paterno_c,T3.tct_apellido_materno_c,T3.tct_nombre_completo_c,
				T3.tct_correo_c,T3.tct_telefono_c,T3.tct_asistencia_c,T3.tct_tipo_registro_c,T4.invitar_c,T4.cuenta_c
				FROM meetings T1
				INNER JOIN meetings_minut_participantes_1_c T2
				ON T2.meetings_minut_participantes_1meetings_ida=T1.id
				INNER JOIN minut_participantes T3
				ON T3.id=T2.meetings_minut_participantes_1minut_participantes_idb
				INNER JOIN minut_participantes_cstm T4
				ON T4.id_c=T3.id
				WHERE T1.id='{$bean->id}'
				AND T1.deleted=0
				AND T2.deleted=0
				AND T3.deleted=0
				ORDER BY T3.date_entered";
				$resultado = $bd = $GLOBALS['db']->query($queryRecord);
				while ($row = $GLOBALS['db']->fetchByAssoc($resultado)) {
					if($row['invitar_c']) {
						if($row['description']) {
						    $host1 = [
								"first_name" => $row['name'],
								"father_last_name" => $row['tct_apellido_paterno_c'],
								"mother_last_name" => $row['tct_apellido_materno_c'],
								"full_name" => $row['name'] . " " . $row['tct_apellido_paterno_c'] . " " . $row['tct_apellido_materno_c'],
								"email" => $row['tct_correo_c'],
								"crm_id" => $row['id'],
							];
							array_push($advisor,$host1);
							$organizador = $row['id'];
						}
						else {
							$participante1 = [
								"first_name" => $row['name'],
								"father_last_name" => $row['tct_apellido_paterno_c'],
								"mother_last_name" => $row['tct_apellido_materno_c'],
								"full_name" => $row['name'] . " " . $row['tct_apellido_paterno_c'] . " " . $row['tct_apellido_materno_c'],
								"email" => $row['tct_correo_c'],
								"crm_id" => $row['id'],
							];
							array_push($guest,$participante1);
						}
						$correo = ["id" => $row['id'], "name" => $row['name'] . " " . $row['tct_apellido_paterno_c'] . " " . $row['tct_apellido_materno_c'], "mail" => $row['tct_correo_c']];
						array_push($correos,$correo);
					}
				}
			}
			if($bean->error_lenia_c) $lenia = 1;
			if($lenia) {
				// Obtiene Token Lenia
				global $db;
				global $sugar_config;
				$url = $sugar_config['lenia'].'videocall/token/';
				$usr = $sugar_config['lenia_usr'];
				$psw = $sugar_config['lenia_psw'];
				$params = "grant_type=password&username=".$usr."&password=".$psw;
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($curl);
				$err = curl_error($curl);
				if ($err) {
					$query = "UPDATE meetings_cstm SET error_lenia_c = 1 WHERE id_c = '{$bean->id}'";
					$queryResult = $db->query($query);						
					$GLOBALS['log']->fatal("Error: ".$err);
				}
				else {
					$response = json_decode($response, true);
					curl_close($curl);
					$token = $response['access_token'];
					// Convierte formato de fecha y hora
					date_default_timezone_set('America/Mexico_City');
					$verano = date('I');
					$scheduled = date('Y-m-d H:i:s', strtotime('-6 hours', strtotime($bean->date_start)));
					if($verano) $scheduled = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($bean->date_start)));
					$inicio = strtotime('-6 hours',strtotime($bean->date_start));
					$fin = strtotime('-6 hours',strtotime($bean->date_end));
					if($verano) $inicio = strtotime('-5 hours',strtotime($bean->date_start));
					if($verano) $fin = strtotime('-5 hours',strtotime($bean->date_end));
					$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					$fecha = $dias[date('w',$inicio)]." ".date('j',$inicio)." de ".$meses[date('n',$inicio)-1]." de ".date('Y',$inicio);
					$hora = date("g:i a",$inicio);
					$start = date('Ymd',$inicio)."T".date('His',$inicio);
					$end = date('Ymd',$fin)."T".date('His',$fin);
					$ini_outlook = date('Y-m-d',$inicio)."T".date('H:i:s',$inicio);
					$fin_outlook = date('Y-m-d',$fin)."T".date('H:i:s',$fin);
					// Invoca servicio para crear o actualizar sala en Lenia
					$url = $sugar_config['lenia'].'videocall/room/add/?meeting_objective_id='.$bean->objetivo_c;
					if($bean->link_lenia_c) $url = $sugar_config['lenia'].'videocall/room/update/?crm_id='.$bean->id.'&room_id='.$bean->link_lenia_c.'&meeting_objective_id='.$bean->objetivo_c;
					$content = json_encode(array(
					  "crm_id" => $bean->id,
					  "session_name" => $bean->name,
					  "room_status" => true,
					  "scheduled_date" => array(
					  "day" => date('d',strtotime($bean->date_start)),
					  "month" => date('m',strtotime($bean->date_start)),
					  "year" => date('Y',strtotime($bean->date_start)),
					  "date" => $scheduled,
					),
					  "guest_list" => $guest,
					  "advisor_list" => $advisor
					));
					$GLOBALS['log']->fatal("Solicitud Lenia: ");
					$GLOBALS['log']->fatal($content);
					$curl = curl_init($url);
					curl_setopt($curl, CURLOPT_HEADER, false);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPHEADER,
					array("Authorization: Bearer $token",
						"Content-type: application/json"));
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					$response = curl_exec($curl);
					$err = curl_error($curl);
					if ($err) {
						$query = "UPDATE meetings_cstm SET error_lenia_c = 1 WHERE id_c = '{$bean->id}'";
						$queryResult = $db->query($query);
						$GLOBALS['log']->fatal("Error: ".$err);
					}
					else {
						curl_close($curl);
						$response = json_decode($response, true);
						$GLOBALS['log']->fatal("Respuesta Lenia: ");
						$GLOBALS['log']->fatal($response);
						if($response['status'] && !$bean->link_lenia_c) {
							// Actualiza ID de Sala en la Reunión
							$descripcion = "El enlace que deberás usar para poder conectarte el día de la videoconferencia es: ".$sugar_config['lenia_url'].$response['idSala']."?".$organizador;
							$query = "UPDATE meetings a, meetings_cstm b
							  SET a.description = '{$descripcion}', b.link_lenia_c = '{$response['idSala']}'
							  WHERE a.id = b.id_c and b.id_c = '{$bean->id}'";
							$queryResult = $db->query($query);
						}
						if($response['status']) {
							$query = "UPDATE meetings_cstm SET error_lenia_c = null WHERE id_c = '{$bean->id}'";
							$queryResult = $db->query($query);
							if($bean->assigned_user_id) {
								$beanUsr = BeanFactory::getBean('Users', $bean->assigned_user_id, array('disable_row_level_security' => true));
								$usuario = $beanUsr->name;
							}
							$sala = $response['idSala'];
							if($bean->link_lenia_c) $sala = $bean->link_lenia_c;
							// Envía correo a los invitados
							foreach ($correos as $correo) {
								require_once("include/SugarPHPMailer.php");
								require_once("modules/EmailTemplates/EmailTemplate.php");
								require_once("modules/Administration/Administration.php");									
								$url = $sugar_config['lenia_url'].$sala."?".$correo["id"];
								$emailtemplate = new EmailTemplate();
								if($organizador == $correo['id']) {
									$emailtemplate->retrieve_by_string_fields(array('name'=>'Lenia Asesor','type'=>'email'));
								}
								else {
									$emailtemplate->retrieve_by_string_fields(array('name'=>'Lenia Cliente','type'=>'email'));
								}
								$asunto = $emailtemplate->subject;
								if($objParticipantes['actualiza']) $asunto = "Actualización: ".$emailtemplate->subject;
								$google = "http://www.google.com/calendar/event?action=TEMPLATE&text=".$asunto."&dates=".$start."/".$end."&location=".$url."&trp=false&details=UNIFIN FINANCIERA";
								$outlook = "https://outlook.live.com/owa/?path=/calendar/action/compose&rru=addevent&startdt=".$ini_outlook."&enddt=".$fin_outlook."&subject=".$asunto."&body=UNIFIN FINANCIERA&location=".$url;
								$office = "https://outlook.office.com/calendar/0/deeplink/compose?subject=".$asunto."&body=UNIFIN FINANCIERA&startdt=".$ini_outlook."&enddt=".$fin_outlook."&location=".$url."&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent";
								$emailtemplate->subject = $asunto;
								$body_html = $emailtemplate->body_html;
								$body_html = str_replace('participante_name', $correo["name"], $body_html);
								$body_html = str_replace('cliente_name', $cuenta_name, $body_html);
								$body_html = str_replace('asesor_name', $usuario, $body_html);
								$body_html = str_replace('fecha', $fecha, $body_html);
								$body_html = str_replace('hora', $hora, $body_html);
								$body_html = str_replace('google', $google, $body_html);
								$body_html = str_replace('outlook', $outlook, $body_html);
								$body_html = str_replace('office', $office, $body_html);
								if($objParticipantes['actualiza']) $body_html = str_replace('ha quedado agendada una', 'se ha actualizado la', $body_html);
								$emailtemplate->body_html = str_replace('url', $url, $body_html);
								$mailer = MailerFactory::getSystemDefaultMailer();
								$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
								$mailer->setSubject($emailtemplate->subject);
								$body = trim($emailtemplate->body_html);
								$mailer->setHtmlBody($body);
								$mailer->clearRecipients();
								$mailer->addRecipientsTo(new EmailIdentity($correo["mail"], $correo["name"]));
								// Crea auditoría de correos
								$userid = $bean->assigned_user_id;
								$recordid = $correo["id"];
								$hoy = date("Y-m-d H:i:s");
								$mail = $correo["mail"];
								try {
									$result = $mailer->send();
									$insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, description)
										VALUES (uuid(), '{$userid}', '{$recordid}', '{$hoy}', '{$mail}', '{$asunto}', 'TO', 'Reuniones', 'OK', 'Correo exitosamente enviado')";
									$GLOBALS['db']->query($insert);
								} catch (Exception $e) {
									$insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, error_code, description)
										VALUES (uuid(), '{$userid}', '{$recordid}', '{$hoy}', '{$mail}', '{$asunto}', 'TO', 'Reuniones', 'ERROR', '01', '{$e->getMessage()}')";
									$GLOBALS['db']->query($insert);
								}
							}
						}
						else {
							$query = "UPDATE meetings_cstm SET error_lenia_c = 1 WHERE id_c = '{$bean->id}'";
							$queryResult = $db->query($query);								
							$GLOBALS['log']->fatal("Error Respuesta Lenia");
							$GLOBALS['log']->fatal($response);
						}
					}
				}
			}
			if ($bean->status == 'Not Held') {
				// Envía correo a los invitados de cancelación
				if($bean->assigned_user_id) {
					$beanUsr = BeanFactory::getBean('Users', $bean->assigned_user_id, array('disable_row_level_security' => true));
					$usuario = $beanUsr->name;
				}
				// Convierte formato de fecha y hora
				date_default_timezone_set('America/Mexico_City');
				$verano = date('I');
				$scheduled = date('Y-m-d H:i:s', strtotime('-6 hours', strtotime($bean->date_start)));
				if($verano) $scheduled = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($bean->date_start)));
				$inicio = strtotime('-6 hours',strtotime($bean->date_start));
				$fin = strtotime('-6 hours',strtotime($bean->date_end));
				if($verano) $inicio = strtotime('-5 hours',strtotime($bean->date_start));
				if($verano) $fin = strtotime('-5 hours',strtotime($bean->date_end));
				$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
				$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				$fecha = $dias[date('w',$inicio)]." ".date('j',$inicio)." de ".$meses[date('n',$inicio)-1]." de ".date('Y',$inicio);
				$hora = date("g:i a",$inicio);
				foreach ($correos as $correo) {
					require_once("include/SugarPHPMailer.php");
					require_once("modules/EmailTemplates/EmailTemplate.php");
					require_once("modules/Administration/Administration.php");									
					$emailtemplate = new EmailTemplate();
					if($organizador == $correo['id']) {
						$emailtemplate->retrieve_by_string_fields(array('name'=>'Lenia Asesor Cancela','type'=>'email'));
					}
					else {
						$emailtemplate->retrieve_by_string_fields(array('name'=>'Lenia Cliente Cancela','type'=>'email'));
					}
					$asunto = $emailtemplate->subject;
					$emailtemplate->subject = $asunto;
					$body_html = $emailtemplate->body_html;
					$body_html = str_replace('participante_name', $correo["name"], $body_html);
					$body_html = str_replace('cliente_name', $cuenta_name, $body_html);
					$body_html = str_replace('asesor_name', $usuario, $body_html);
					$body_html = str_replace('fecha', $fecha, $body_html);
					$emailtemplate->body_html = str_replace('hora', $hora, $body_html);
					$mailer = MailerFactory::getSystemDefaultMailer();
					$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
					$mailer->setSubject($emailtemplate->subject);
					$body = trim($emailtemplate->body_html);
					$mailer->setHtmlBody($body);
					$mailer->clearRecipients();
					$mailer->addRecipientsTo(new EmailIdentity($correo["mail"], $correo["name"]));
					// Crea auditoría de correos
					$userid = $bean->assigned_user_id;
					$recordid = $correo["id"];
					$hoy = date("Y-m-d H:i:s");
					$mail = $correo["mail"];
					try {
						$result = $mailer->send();
						$insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, description)
							VALUES (uuid(), '{$userid}', '{$recordid}', '{$hoy}', '{$mail}', '{$asunto}', 'TO', 'Reuniones', 'OK', 'Correo exitosamente enviado')";
						$GLOBALS['db']->query($insert);
					} catch (Exception $e) {
						$insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, error_code, description)
							VALUES (uuid(), '{$userid}', '{$recordid}', '{$hoy}', '{$mail}', '{$asunto}', 'TO', 'Reuniones', 'ERROR', '01', '{$e->getMessage()}')";
						$GLOBALS['db']->query($insert);
					}
				}
			}
		}
    }
}