<?php
/*/**
 * Created by Eduardo Carrasco Beltrán
 * Date: 11/07/2023
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class altaDireccionUnifin extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'altaDireccionUnifin' => array(
                'reqType' => 'POST',
                'path' => array('altaDireccionUnifin'),
                'pathVars' => array(''),
                'method' => 'altaDireccion',
                'shortHelp' => 'Consumo para dar de alta Direcciones de Creditaria',
            ),
        );
    }

	public function altaDireccion($api, $args) {
		$response = array();
		$response['statusCode']='200';
		$response['message']='Registro procesado de forma correcta';
		$response['id']='';
		return $response;
	}
}
