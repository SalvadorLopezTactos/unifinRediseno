<?php 
/**
 * @author: Salvador Lopez
 * @date: 02/06/2021
 */ 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CondicionesFinancierasQuantico extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'recuperaID' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('CondicionesFinancierasQuantico'),
                'pathVars' => array(''),
                'method' => 'consumeServiciosQuanticoCF',
                'shortHelp' => 'API custom para consumir los servicios disponibles de Quantico sobre condiciones financieras',
            ),
        );
    }

    public function consumeServiciosQuanticoCF($api, $args){

        global $sugar_config, $db, $app_list_strings;
        $user = $sugar_config['quantico_usr'];
        $pwd = $sugar_config['quantico_psw'];
        $auth_encode = base64_encode($user . ':' . $pwd);

        $GLOBALS['log']->fatal("VARIABLES ".$args['tipo']);
        

        $host = $sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetProductFinancialTermGroup?ProductTypeId=1&ProductId=0';

        $callApi = new UnifinAPI();
        $resultado = $callApi->getQuanticoCF($host, $auth_encode);

        return $resultado;

    }
}