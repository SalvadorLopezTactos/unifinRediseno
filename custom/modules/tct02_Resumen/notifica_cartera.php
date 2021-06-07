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
			if($bean->bloqueo_cartera_c) {
				$razon = $app_list_strings['razon_list'][$bean->razon_c];
				$detalle = $bean->detalle_c;
				$bloqueo = 1;
			}
			if($bean->bloqueo2_c) {
				$razon = $app_list_strings['razon_list'][$bean->razon2_c];
				$detalle = $bean->detalle2_c;
				$bloqueo = 1;
			}
			if($bean->bloqueo3_c) {
				$razon = $app_list_strings['razon_list'][$bean->razon3_c];
				$detalle = $bean->detalle3_c;
				$bloqueo = 1;
			}
			if($bloqueo || $bean->fetched_row['grupo_c'] != $bean->grupo_c) {
				//Busca Grupo Empresarial
				$beanAcct = BeanFactory::retrieveBean('Accounts', $bean->id, array('disable_row_level_security' => true));
				if($beanAcct->load_relationship('members')) {
					$relatedBeans = $beanAcct->members->getBeans();
					if (!empty($relatedBeans)) {
						foreach ($relatedBeans as $member) {
							if($bean->fetched_row['bloqueo_cartera_c'] != $bean->bloqueo_cartera_c) {
								if($member->tct_no_contactar_chk_c) {
									$member->tct_no_contactar_chk_c = 0;
								}else{
									$member->tct_no_contactar_chk_c = 1;
								}
								$member->save();
								$actualiza = <<<SQL
update tct02_resumen_cstm set condicion_cliente_c = '{$bean->condicion_cliente_c}', razon_c = '{$bean->razon_c}', motivo_c = '{$bean->motivo_c}', detalle_c = '{$bean->detalle_c}',
user_id_c = '{$bean->user_id_c}', user_id1_c = '{$bean->user_id1_c}', bloqueo_cartera_c = '{$bean->bloqueo_cartera_c}' where id_c = '{$member->id}'
SQL;
								$Result = $db->query($actualiza);
							}
							if($bean->fetched_row['bloqueo2_c'] != $bean->bloqueo2_c) {
								$actualiza = <<<SQL
update tct02_resumen_cstm set condicion2_c = '{$bean->condicion2_c}', razon2_c = '{$bean->razon2_c}', motivo2_c = '{$bean->motivo2_c}', detalle2_c = '{$bean->detalle2_c}',
user_id2_c = '{$bean->user_id2_c}', user_id3_c = '{$bean->user_id3_c}', bloqueo_credito_c = '{$bean->bloqueo_credito_c}', bloqueo2_c = '{$bean->bloqueo2_c}' where id_c = '{$member->id}'
SQL;
								$Result = $db->query($actualiza);
							}
							if($bean->fetched_row['bloqueo3_c'] != $bean->bloqueo3_c) {
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
			$team->retrieve($app_list_strings['cartera_list']['Cartera']);
			$team_members = $team->get_team_members(true);
            $correos=array();
			$nombres=array();
			foreach($team_members as $user) {
				array_push($correos,$user->email1);
				array_push($nombres,$user->nombre_completo_c);
			}			
			//Notifica Bloqueo
			if($bloqueo && !$bean->grupo_c) {
				$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que la cuenta <b>'.$bean->name.'</b> ha sido bloqueada por el equipo de <b>'.$equipo.'</b>
				<br><br>La razón de bloqueo es: <b>'.$razon.'</b>
				<br><br>y el detalle: <b>'.$detalle.'</b></font></p>';
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject('Cuenta '.$bean->name.' bloqueada por el equipo de '.$equipo);
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				for ($i=0; $i < count($correos); $i++) {
					$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
				}
				$result = $mailer->send();
			}
			//Notifica Desbloqueo
			if(!$bloqueo && $bean->grupo_c) {
				$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
				Se le informa que la cuenta <b>'.$bean->name.'</b> ha sido desbloqueada por el equipo de <b>'.$equipo.'</b></font></p>';
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject('Cuenta '.$bean->name.' desbloqueada por el equipo de '.$equipo);
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				for ($i=0; $i < count($correos); $i++) {
					$mailer->addRecipientsTo(new EmailIdentity($correos[$i], $nombres[$i]));
				}
				$result = $mailer->send();
				$bean->grupo_c = 0;
			}
		}
    }
}
