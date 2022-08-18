<?php
/**
 * User: Tactos
 * Date: 16/08/2022
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class email_TDC extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'email_TDC' => array(
                'reqType' => 'POST',
                'path' => array('email_TDC'),
                'pathVars' => array(''),
                'method' => 'emailTDC',
                'shortHelp' => 'Cambia correo y genera nueva contraseña para la APP UnifinCard',
            ),
        );
    }

    public function emailTDC($api, $args){
        //Recupera variables
        $idCuenta = isset($args['idCuenta']) ? $args['idCuenta'] : '';
        $idrelacion = isset($args['idRelacion']) ? $args['idRelacion'] : '';
		$relaciones = isset($args['relaciones']) ? $args['relaciones'] : '';
		$correo = isset($args['correo']) ? $args['correo'] : '';
		$resultado = [];
		$admin = false;
		foreach ($relaciones as $val) {
			if($val == 'Administrador de Tarjeta de Credito') $admin = true;
		}
        //Recupera correo de la cuenta relacionada
		$beanRel = BeanFactory::retrieveBean('Accounts', $idrelacion, array('disable_row_level_security' => true));
		if (!$correo) $correo = $beanRel->email1;
		//Recupera teléfono principal de la cuenta relacionada
		if ($beanRel->load_relationship('accounts_tel_telefonos_1')) {
			$tel_telefonos = $beanRel->accounts_tel_telefonos_1->getBeans();
            if (!empty($tel_telefonos)) {
                foreach ($tel_telefonos as $tel) {
					if (!empty($tel->id) && $tel->principal) $telefono = $tel->telefono;
				}
			}
		}
		//Recupera solicitud de TDC de la cuenta principal
		$beanCuenta = BeanFactory::retrieveBean('Accounts', $idCuenta, array('disable_row_level_security' => true));
        if ($beanCuenta->load_relationship('opportunities')) {
            $parametros = array(
				'orderby' => 'date_modified DESC',
				'disable_row_level_security' => true
			);
			$ya = 0;
            $opps_relacionadas = $beanCuenta->opportunities->getBeans($beanCuenta->id, $parametros);
            if (!empty($opps_relacionadas)) {
                foreach ($opps_relacionadas as $opp) {
					if($opp->tipo_producto_c == 14 && $opp->estatus_c == 'N' && $ya == 0) {
						$solicitud = $opp->id;
						$ya = 1;
					}
                }
            }
        }
		//Recupera Token
		global $sugar_config;
		$url = $sugar_config['tdc_tkn'];
		$usr = $sugar_config['tdc_usr'];
		$psw = $sugar_config['tdc_psw'];
		$params = "grant_type=password&client_id=system&username=".$usr."&password=".$psw;
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
            $resultado['status'] = '300';
            $resultado['message'] = 'Error de autenticación';
			$GLOBALS['log']->fatal("Error TDC: ".$err);
		}
		else {
			curl_close($curl);
			$response = json_decode($response, true);
			$token = $response['access_token'];
			if ($token) {
				//Invoca servicio de TDC
				$cardholders = array();
				$relacionado = [
					"cardholderUuid" => $idrelacion,
					"email" => $correo,
					"phone" => $telefono,
					"adminFlag" => $admin,
					"workArea" => 1,
					"urlTracking" => "urlTracking",
					"guideTracking" => "guideTracking",
					"cardUse" => null
				];
				array_push($cardholders,$relacionado);
				$content = json_encode(array(
					"customerUuid" => $idCuenta,
					"opportunityUuid" => $solicitud,
					"cardholders" => $cardholders
				));
				$GLOBALS['log']->fatal("Solicitud TDC: ");
				$GLOBALS['log']->fatal($content);
				$url = $sugar_config['tdc'];
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
				curl_close($curl);
				$response = json_decode($response, true);
				if ($err) {
					$resultado['status'] = '300';
					$resultado['message'] = $err;
					$GLOBALS['log']->fatal("Error TDC: ");
					$GLOBALS['log']->fatal($err);
				}
				else {
					if ($response['success']) {
						$resultado['status'] = '200';
						$resultado['message'] = $response['data']['resultDescription'];
						$GLOBALS['log']->fatal("Éxito TDC: ".$response['data']['resultDescription']);
					}
					else {
						$resultado['status'] = '300';
						$resultado['message'] = $response['data']['resultDescription'];;
						$GLOBALS['log']->fatal("Error TDC: ");
						$GLOBALS['log']->fatal($response);
					}
				}
			}
			else {
				$resultado['status'] = '300';
				$resultado['message'] = 'Error de autenticación';
				$GLOBALS['log']->fatal("Error TDC: ");
				$GLOBALS['log']->fatal($response);
			}
		}
        return $resultado;
    }
}
