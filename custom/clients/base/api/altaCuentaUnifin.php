<?php
/*/**
 * Created by Eduardo Carrasco Beltrán
 * Date: 11/07/2023
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class altaCuentaUnifin extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'altaCuentaUnifin' => array(
                'reqType' => 'POST',
                'path' => array('altaCuentaUnifin'),
                'pathVars' => array(''),
                'method' => 'altaCuenta',
                'shortHelp' => 'Consumo para dar de alta Cuentas de Creditaria',
            ),
        );
    }

	public function altaCuenta($api, $args) {
		$response = array();
		$response['statusCode']='200';
		$response['message']='Registro procesado de forma correcta';
		$response['id']='';
		return $response;
	}
}
