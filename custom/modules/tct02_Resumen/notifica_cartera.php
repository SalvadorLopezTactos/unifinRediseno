<?php
class notifica_cartera
{
    function notifica_cartera($bean, $event, $arguments)
    {
		if($bean->fetched_row['bloqueo_cartera_c'] != $bean->bloqueo_cartera_c || $bean->fetched_row['bloqueo2_c'] != $bean->bloqueo2_c || $bean->fetched_row['bloqueo3_c'] != $bean->bloqueo3_c) {
			$equipo = '';
			$razon = '';
			$detalle = '';
			$bloqueo = 0;
			global $db;
			global $app_list_strings;
			if($bean->fetched_row['bloqueo_cartera_c'] != $bean->bloqueo_cartera_c) $equipo = 'Cartera';
			if($bean->fetched_row['bloqueo2_c'] != $bean->bloqueo2_c) $equipo = 'Crédito';
			if($bean->fetched_row['bloqueo3_c'] != $bean->bloqueo3_c) $equipo = 'Cumplimiento';
			if(!$bean->fetched_row['bloqueo_cartera_c'] && $bean->bloqueo_cartera_c) {
				$razon = $app_list_strings['razon_list'][$bean->razon_c];
				$detalle = $bean->detalle_c;
				$bloqueo = 1;
			}
			if(!$bean->fetched_row['bloqueo2_c'] && $bean->bloqueo2_c) {
				$razon = $app_list_strings['razon_list'][$bean->razon2_c];
				$detalle = $bean->detalle2_c;
				$bloqueo = 1;
			}
			if(!$bean->fetched_row['bloqueo3_c'] && $bean->bloqueo3_c) {
				$razon = $app_list_strings['razon_list'][$bean->razon3_c];
				$detalle = $bean->detalle3_c;
				$bloqueo = 1;
			}
			if($bloqueo || $bean->fetched_row['grupo_c'] != $bean->grupo_c || (!$bean->bloqueo_cartera_c && !$bean->bloqueo2_c && !$bean->bloqueo3_c)) {
				//Actualiza Productos
				$estatus = "";
				$beanAcct = BeanFactory::retrieveBean('Accounts', $bean->id, array('disable_row_level_security' => true));
				$beanAcct->load_relationship('accounts_uni_productos_1');
				$relatedBeans = $beanAcct->accounts_uni_productos_1->getBeans();
				foreach ($relatedBeans as $rel) {
					if($bloqueo) $estatus = 3;
					if(!$bean->bloqueo_cartera_c && !$bean->bloqueo2_c && !$bean->bloqueo3_c) {
						$query = "select before_value_string from uni_productos_audit where field_name = 'estatus_atencion' and parent_id = '{$rel->id}' and before_value_string <> '' order by date_created desc";
						$results = $db->query($query);
						$row = $db->fetchByAssoc($results);
						$estatus = $row['before_value_string'];
					}
					$rel->estatus_atencion = $estatus;
					$rel->save();
				}
				//Busca Grupo Empresarial
				if($beanAcct->load_relationship('members')) {
					$relatedBeans = $beanAcct->members->getBeans();
					if (!empty($relatedBeans)) {
						foreach ($relatedBeans as $member) {
							//Actualiza Productos
							$beanAcct1 = BeanFactory::retrieveBean('Accounts', $member->id, array('disable_row_level_security' => true));
							$beanAcct1->load_relationship('accounts_uni_productos_1');
							$relatedBeans1 = $beanAcct1->accounts_uni_productos_1->getBeans();
							foreach ($relatedBeans1 as $rel1) {
								if($bloqueo) $estatus = 3;
								if(!$bean->bloqueo_cartera_c && !$bean->bloqueo2_c && !$bean->bloqueo3_c) {
									$query1 = "select before_value_string from uni_productos_audit where field_name = 'estatus_atencion' and parent_id = '{$rel1->id}' order by date_created desc";
									$results1 = $db->query($query1);
									$row1 = $db->fetchByAssoc($results1);
									$estatus = $row1['before_value_string'];
								}
								$rel1->estatus_atencion = $estatus;
								$rel1->save();
							}
							//Actualiza Grupo Empresarial
							if($bean->fetched_row['bloqueo_cartera_c'] != $bean->bloqueo_cartera_c) {
								if($member->tct_no_contactar_chk_c) {
									$member->tct_no_contactar_chk_c = 0;
								}else{
									$member->tct_no_contactar_chk_c = 1;
								}
								$member->save();
								if($bean->bloqueo_cartera_c == '') $bean->bloqueo_cartera_c = 0;
								$actualiza = <<<SQL
update tct02_resumen_cstm set condicion_cliente_c = '{$bean->condicion_cliente_c}', razon_c = '{$bean->razon_c}', motivo_c = '{$bean->motivo_c}', detalle_c = '{$bean->detalle_c}',
user_id_c = '{$bean->user_id_c}', user_id1_c = '{$bean->user_id1_c}', bloqueo_cartera_c = '{$bean->bloqueo_cartera_c}' where id_c = '{$member->id}'
SQL;
								$Result = $db->query($actualiza);
							}
							if($bean->fetched_row['bloqueo2_c'] != $bean->bloqueo2_c) {
								if($bean->bloqueo2_c == '') $bean->bloqueo2_c = 0;
								$actualiza = <<<SQL
update tct02_resumen_cstm set condicion2_c = '{$bean->condicion2_c}', razon2_c = '{$bean->razon2_c}', motivo2_c = '{$bean->motivo2_c}', detalle2_c = '{$bean->detalle2_c}',
user_id2_c = '{$bean->user_id2_c}', user_id3_c = '{$bean->user_id3_c}', bloqueo_credito_c = '{$bean->bloqueo_credito_c}', bloqueo2_c = '{$bean->bloqueo2_c}' where id_c = '{$member->id}'
SQL;
								$Result = $db->query($actualiza);
							}
							if($bean->fetched_row['bloqueo3_c'] != $bean->bloqueo3_c) {
								if($bean->bloqueo3_c == '') $bean->bloqueo3_c = 0;
								$actualiza = <<<SQL
update tct02_resumen_cstm set condicion3_c = '{$bean->condicion3_c}', razon3_c = '{$bean->razon3_c}', motivo3_c = '{$bean->motivo3_c}', detalle3_c = '{$bean->detalle3_c}',
user_id4_c = '{$bean->user_id4_c}', user_id5_c = '{$bean->user_id5_c}', bloqueo_cumple_c = '{$bean->bloqueo_cumple_c}', bloqueo3_c = '{$bean->bloqueo3_c}' where id_c = '{$member->id}'
SQL;
								$Result = $db->query($actualiza);
							}
						}
					}
				}
			}
			require_once 'include/SugarPHPMailer.php';
			require_once 'modules/Administration/Administration.php';
			include_once('modules/Teams/Team.php');
			$team = new Team();
			$equipo_sin_tilde=str_replace('é','e',$equipo);
			$valor_equipo=$app_list_strings['equipos_bloqueo_list'][$equipo_sin_tilde];
			$team->retrieve($valor_equipo);
			$team_members = $team->get_team_members(true);
            $correos=array();
			$nombres=array();
			foreach($team_members as $user) {
				array_push($correos,$user->email1);
				array_push($nombres,$user->nombre_completo_c);
			}
			$linkCuenta=$GLOBALS['sugar_config']['site_url'].'/#Accounts/'.$bean->id;
			//Notifica Bloqueo
			if($bloqueo && !$bean->grupo_c) {
				//Nombre del usuario que confirmó el bloqueo
				$id_usuario="";
				if($bean->tct_no_contactar_chk_c==1){
					$id_usuario=$bean->user_id1_c;
				}
				if($bean->bloqueo_credito_c){
					$id_usuario=$bean->user_id3_c;
				}
				if($bean->bloqueo_cumple_c){
					$id_usuario=$bean->user_id5_c;
				}

				$beanUser = BeanFactory::retrieveBean('Users', $id_usuario, array('disable_row_level_security' => true));
				$nombre_usuario=$beanUser->nombre_completo_c;

				$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que '.$nombre_usuario.' ha confirmado el bloqueo de la cuenta <b><a id="linkCuenta" href="'.$linkCuenta.'">'.$bean->name.'</a></b> en CRM y ha sido indicado como responsable de validación.
				<br><br>Atentamente Unifin</font></p>
				<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
				<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
				Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
				Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
				No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
				Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject('Confirmación de bloqueo de Cuenta');
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				for ($i=0; $i < count($correos); $i++) {
					$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
				}
				try {
					$result = $mailer->send();
				} catch
				(Exception $e) {
					$GLOBALS['log']->fatal('Error mail cartera bloqueo: '. $e->getMessage());
				}
				
			}
			//Notifica Desbloqueo
			if(!$bloqueo || $bean->grupo_c) {
				$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
				Se le informa que la cuenta <b><a id="linkCuenta" href="'.$linkCuenta.'">'.$bean->name.'</a></b> ha sido desbloqueada por el equipo de <b>'.$equipo.'</b>
				<br><br>Atentamente Unifin</font></p>
				<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>		
				<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
				Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
				Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
				No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
				Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject('Cuenta '.$bean->name.' desbloqueada por el equipo de '.$equipo);
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				for ($i=0; $i < count($correos); $i++) {
					$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
				}
				try {
					$result = $mailer->send();
				} catch
				(Exception $e) {
					$GLOBALS['log']->fatal('Error mail cartera desbloqueo: '. $e->getMessage());
				}
			}
			$bean->grupo_c = 0;
		}
    }
}
