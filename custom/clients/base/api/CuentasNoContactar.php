<?php
/**
 * Created by PhpStorm.
 * User: Salvador Lopez <salvador.lopez@tactos.com.mx>
 * Date: 11/11/2019
 */

require_once("custom/Levementum/DropdownValuesHelper.php");
require_once("custom/Levementum/UnifinAPI.php");
require_once('config_override.php');

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CuentasNoContactar extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getCuentasNoContactar' => array(
                'reqType' => 'GET',
                'path' => array('CuentasNoContactar', '?'),
                'pathVars' => array('', 'id'),
                'method' => 'getCuentasNoContactar',
                'shortHelp' => 'Obtener cuentas para establecer: No Contactar',
            ),
            'updateCuentasNoContactar' => array(
                'reqType' => 'POST',
                'path' => array('ActualizarCuentasNoContactar'),
                'pathVars' => array(''),
                'method' => 'updateCuentasNoContactar',
                'shortHelp' => 'Establece Cuentas como No Contactar y se le asigna el asesor 9.- Moroso junto con Solicitudes y Backlog',
            ),

        );
    }

    public function getCuentasNoContactar($api, $args)
    {
        try {
            global $db;
            $user_id = $args['id'];
            //"c57e811e-b81a-cde4-d6b4-5626c9961772?PRODUCTO=LEASING?0?&tipos_cuenta=Lead,Prospecto,Cliente,Persona,Proveedor"
            $offset = $args['from'];
            $filtroCliente = $args['cliente'];
            //Omitiendo espacios en blanco
            $filtroCliente = trim($filtroCliente);
            $filtroTipoCuenta = $args['tipos_cuenta'];
            $tipos_separados = explode(",", $filtroTipoCuenta);
            $arr_aux = array();
            for ($i = 0; $i < count($tipos_separados); $i++) {
                array_push($arr_aux, "'" . $tipos_separados[$i] . "'");
            }
            $tipos_query = join(',', $arr_aux);
            $total_rows = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_cuenta_c, idcliente_c, tct_no_contactar_chk_c, bloqueo_credito_c, bloqueo_cumple_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
INNER JOIN tct02_resumen_cstm ON tct02_resumen_cstm.id_c = accounts.id
SQL;
            if ($user_id == "undefined") {
                $total_rows .= " WHERE tipo_registro_cuenta_c IN({$tipos_query}) AND deleted =0";
            } else {
                $total_rows .= " WHERE tipo_registro_cuenta_c IN({$tipos_query})
AND (accounts_cstm.user_id_c='{$user_id}' OR accounts_cstm.user_id1_c='{$user_id}' OR accounts_cstm.user_id2_c='{$user_id}' OR accounts_cstm.user_id6_c='{$user_id}')
 AND deleted=0";
            }
            if (!empty($filtroCliente)) {
                $total_rows .= " AND name LIKE '%{$filtroCliente}%' ";
            }
            $totalResult = $db->query($total_rows);
            $response['total'] = $totalResult->num_rows;
            while ($row = $db->fetchByAssoc($totalResult)) {
                $response['full_cuentas'][] = $row['id'];
            }
            $query = <<<SQL
SELECT id, name, tipodepersona_c, tipo_registro_cuenta_c, rfc_c, idcliente_c, tct_no_contactar_chk_c, bloqueo_credito_c, bloqueo_cumple_c FROM accounts
INNER JOIN accounts_cstm ON accounts_cstm.id_c = accounts.id
INNER JOIN tct02_resumen_cstm ON tct02_resumen_cstm.id_c = accounts.id
SQL;
            if ($user_id == "undefined") {
                $query .= " WHERE tipo_registro_cuenta_c IN({$tipos_query}) AND deleted =0";
            } else {
                $query .= " WHERE tipo_registro_cuenta_c IN({$tipos_query})
AND (accounts_cstm.user_id_c='{$user_id}' OR accounts_cstm.user_id1_c='{$user_id}' OR accounts_cstm.user_id2_c='{$user_id}' OR accounts_cstm.user_id6_c='{$user_id}')
 AND deleted=0";
            }
            if (!empty($filtroCliente)) {
                $query .= " AND name LIKE '%{$filtroCliente}%' ";
            }
            $query .= " ORDER BY name ASC LIMIT 20 OFFSET {$offset}";
            $queryResult = $db->query($query);
            $response['total_cuentas'] = $queryResult->num_rows;
            while ($row = $db->fetchByAssoc($queryResult)) {
                $response['cuentas'][] = $row;
            }
            return $response;
        } catch (Exception $e) {
            global $current_user;
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> :  Error " . $e->getMessage());
        }
    }

    public function updateCuentasNoContactar($api, $args)
    {
		try {
			global $db, $current_user;
			$cuentas = $args['data']['cuentas'];
			$parame = $args['data']['parame'];
			$selected = $args['data']['selected'];
			$cuentas_resumen['actualizados']=array();
			$cuentas_resumen['no_actualizados']=array();
			$IntValue = new DropdownValuesHelper();
			$callApi = new UnifinAPI();
			$bloqueo = 0;
			for ($i = 0; $i < count($cuentas); $i++) {
				$account = BeanFactory::getBean('Accounts', trim($cuentas[$i]), array('disable_row_level_security' => true));
				if ($account->id != null) {
					$cuenta = $account->name;
					$idcuenta = $account->id;
					if(trim($selected) == "selected1") {
						if($account->fetched_row['tct_no_contactar_chk_c']==1){
							$account->tct_no_contactar_chk_c = 0;
						}else{
							$account->tct_no_contactar_chk_c = 1;
							$bloqueo = 1;
						}
						$account->save();
					}
					$resumen = BeanFactory::getBean('tct02_Resumen', trim($cuentas[$i]), array('disable_row_level_security' => true));
					if ($resumen->id != null) {
						if(trim($selected) == "selected2") {
							if($resumen->fetched_row['bloqueo_credito_c']==1){
								$resumen->bloqueo_credito_c = 0;
							}else{
								$resumen->bloqueo_credito_c = 1;
								$bloqueo = 1;
							}
						}
						if(trim($selected) == "selected3") {
							if($resumen->fetched_row['bloqueo_cumple_c']==1){
								$resumen->bloqueo_cumple_c = 0;
							}else{
								$resumen->bloqueo_cumple_c = 1;
								$bloqueo = 1;
							}
						}
						if($bloqueo) {
							if(trim($selected) == "selected1") {
								$query = "update tct02_resumen_cstm set bloqueo_cartera_c = 0 where id_c = '{$resumen->id}'";
								$resumen->condicion_cliente_c = $parame["condicion"];
								$resumen->razon_c = $parame["razon"];
								$resumen->motivo_c = $parame["motivo"];
								$resumen->detalle_c = $parame["detalle"];
								$resumen->user_id_c = $parame["ingesta"];
								$resumen->user_id1_c = $parame["valida"];
							}
							if(trim($selected) == "selected2") {
								$query = "update tct02_resumen_cstm set bloqueo2_c = 0 where id_c = '{$resumen->id}'";
								$resumen->condicion2_c = $parame["condicion"];
								$resumen->razon2_c = $parame["razon"];
								$resumen->motivo2_c = $parame["motivo"];
								$resumen->detalle2_c = $parame["detalle"];
								$resumen->user_id2_c = $parame["ingesta"];
								$resumen->user_id3_c = $parame["valida"];
							}
							if(trim($selected) == "selected3") {
								$query = "update tct02_resumen_cstm set bloqueo3_c = 0 where id_c = '{$resumen->id}'";
								$resumen->condicion3_c = $parame["condicion"];
								$resumen->razon3_c = $parame["razon"];
								$resumen->motivo3_c = $parame["motivo"];
								$resumen->detalle3_c = $parame["detalle"];
								$resumen->user_id4_c = $parame["ingesta"];
								$resumen->user_id5_c = $parame["valida"];
							}
							$queryResult = $db->query($query);
							//Notifica bloqueo al Resposable de validación
							global $app_list_strings;
							require_once 'include/SugarPHPMailer.php';
							require_once 'modules/Administration/Administration.php';
							$ingesta = BeanFactory::retrieveBean('Users', $parame["ingesta"]);
							$lista_usuarios=$parame["valida_users"];
							
							$GLOBALS['log']->fatal(print_r($lista_usuarios_notificar,true));
							//$valida = BeanFactory::retrieveBean('Users', $parame["valida"]);
							$linkCuenta=$GLOBALS['sugar_config']['site_url'].'/#Accounts/'.$idcuenta;
							$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
							Se le informa que el asesor '.$ingesta->nombre_completo_c.' ha solicitado el bloqueo de la cuenta '.$cuenta.' en CRM.<br>
							Para autorizar el bloqueo dé click en el siguiente enlace <b><a id="linkCuenta" href="'.$linkCuenta.'">'.$cuenta.'</a></b>
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
							$mailer->setSubject('Solicitud de bloqueo de Cuenta en CRM');
							$body = trim($mailHTML);
							$mailer->setHtmlBody($body);
							$mailer->clearRecipients();
							if(count($lista_usuarios)>0){
								for ($i=0; $i < count($lista_usuarios); $i++) { 
									$usuario_validador = BeanFactory::retrieveBean('Users', $lista_usuarios[$i]);
									//$info_usuario=array("email"=>$usuario_validador->email1,"name"=>$usuario_validador->first_name . ' ' . $usuario_validador->last_name);
									//array_push($lista_usuarios_notificar,$info_usuario);
									$GLOBALS['log']->fatal("AGREGANDO EL EMAIL: ".$usuario_validador->email1." A LA LISTA");
									$mailer->addRecipientsTo(new EmailIdentity($usuario_validador->email1, $usuario_validador->first_name . ' ' . $usuario_validador->last_name));
								}
							}
							//$mailer->addRecipientsTo(new EmailIdentity($valida->email1, $valida->first_name . ' ' . $valida->last_name));
							$result = $mailer->send();
						}else{
							//Notifica desbloqueo al Resposable de validación
							global $app_list_strings;
							require_once 'include/SugarPHPMailer.php';
							require_once 'modules/Administration/Administration.php';
							$ingesta = BeanFactory::retrieveBean('Users', $parame["ingesta"]);
							//$valida = BeanFactory::retrieveBean('Users', $parame["valida"]);
							$lista_usuarios=$parame["valida_users"];
							$linkCuenta=$GLOBALS['sugar_config']['site_url'].'/#Accounts/'.$idcuenta;
							$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">
							Se le informa que el asesor '.$ingesta->nombre_completo_c.' ha solicitado el desbloqueo de la cuenta '.$cuenta.' en CRM.<br>
							Se requiere de su aprobación para desbloquear definitivamente la cuenta.<br>
							Para autorizar el desbloqueo dé click en el siguiente enlace <b><a id="linkCuenta" href="'.$linkCuenta.'">'.$cuenta.'</a></b>
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
							$mailer->setSubject('Solicitud de desbloqueo de Cuenta en CRM');
							$body = trim($mailHTML);
							$mailer->setHtmlBody($body);
							$mailer->clearRecipients();
							if(count($lista_usuarios)>0){
								for ($i=0; $i < count($lista_usuarios); $i++) { 
									$usuario_desbloqueo = BeanFactory::retrieveBean('Users', $lista_usuarios[$i]);
									$mailer->addRecipientsTo(new EmailIdentity($usuario_desbloqueo->email1, $usuario_desbloqueo->first_name . ' ' . $usuario_desbloqueo->last_name));
								}
							}
							$result = $mailer->send();
						} //else
						$resumen->save();
					} //if
					array_push($cuentas_resumen['actualizados'],$cuentas[$i]);
				}else{
					if($cuentas[$i]) array_push($cuentas_resumen['no_actualizados'],$cuentas[$i]);
				}
			} //for
			return $cuentas_resumen;
        } //try
		catch (Exception $e) {
            array_push($cuentas_resumen['no_actualizados'],$cuentas[$i]);
            return $cuentas_resumen;
        }
    }
}