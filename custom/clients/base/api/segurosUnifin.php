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
		try {
			global $db;
			$response = array();
			$id = $args['id'];
			$query = "select * from s_seguros a, s_seguros_cstm b where a.id = b.id_c and a.deleted = 0 and a.id = '{$id}'";
			$queryResult = $db->query($query);
			$Seguro = $db->fetchByAssoc($queryResult);
			$response = $Seguro;
			$query = "select * from cot_cotizaciones a, cot_cotizaciones_cstm b where a.id = b.id_c and a.deleted = 0 and a.id in (select cot_cotizaciones_s_seguroscot_cotizaciones_idb from cot_cotizaciones_s_seguros_c where cot_cotizaciones_s_seguross_seguros_ida = '{$id}')";
			$queryResult = $db->query($query);
			$Cotizaciones = $db->fetchByAssoc($queryResult);			
			$response['cotizaciones'] = $Cotizaciones;
		} catch (Exception $e) {
            $response['statusCode']='400';
            $response['message']=$e->getMessage();
        }
		return $response;
    }
}

?>
