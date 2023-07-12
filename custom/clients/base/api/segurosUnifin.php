<?php
/**
 * User: Eduardo Carrasco Beltrán
 * Date: 11/07/2023
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class segurosUnifin extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('segurosUnifin', '?'),
                'pathVars' => array('method', 'id'),
                'method' => 'getSegurosUnifin',
                'shortHelp' => 'Devuelve Cotizaciones de una Oportunidad de Seguro',
                'longHelp' => '',
            ),
        );
    }

    public function getSegurosUnifin($api, $args)
    {
		$response = array();
		$response['statusCode']='200';
		$response['message']='Registro procesado de forma correcta';
		$response['id']='';
		return $response;
    }


}

?>
