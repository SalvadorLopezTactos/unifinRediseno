<?php
/*/**
 * Created by Eduardo Carrasco Beltrán
 * Date: 11/07/2023
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class altaSegurosUnifin extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'altaSegurosUnifin' => array(
                'reqType' => 'POST',
                'path' => array('altaSegurosUnifin'),
                'pathVars' => array(''),
                'method' => 'altaSeguros',
                'shortHelp' => 'Consumo para dar de alta Oportunidades de Seguro de Creditaria',
            ),
        );
    }

	public function altaSeguros($api, $args) {
		$response = array();
		$response['statusCode']='200';
		$response['message']='Registro procesado de forma correcta';
		$response['id']='';
		return $response;
	}
}
