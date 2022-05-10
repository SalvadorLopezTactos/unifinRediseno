<?php 
/**
 * @author: Salvador Lopez
 * @date: 02/06/2021
 */ 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("custom/Levementum/UnifinAPI.php");

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
        $tipo_producto=$args['tipo_producto'];
        $product_id=$args['product_id'];

        $variableServicio=$args['productoFinanciero'];
        if(isset($variableServicio)){
            $host = $sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetFinancialProduct';
            $callApi = new UnifinAPI();
            $resultado = $callApi->getQuanticoCF($host, $auth_encode);
        }else {
            $host = $sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetProductFinancialTermGroup?ProductTypeId='.$tipo_producto.'&ProductId='.$product_id;
            $GLOBALS['log']->fatal('HOST: '.$host);
            $host_lista_activo=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetAssetRequest';
            $host_lista_factoraje=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetProductFactoringType';
            $host_lista_instrumento_financiero=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetFinancialInstrument';
            $host_lista_comision=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetCommissionType';
            $host_lista_calculo=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetCollectionCalculationType';
            $host_lista_tipo_tasa=$sugar_config['quantico_url_base'] . '/CreditRequestIntegration/rest/CreditRequestApi/GetRateType';

            $callApi = new UnifinAPI();
            $resultado = $callApi->getQuanticoCF($host, $auth_encode);
            $resultado['listaValores']=[];

            $resultado['listaValores']['TipoActivo']=$callApi->getQuanticoCF($host_lista_activo, $auth_encode);
            $resultado['listaValores']['TipoFactoraje']=$callApi->getQuanticoCF($host_lista_factoraje, $auth_encode);
            $resultado['listaValores']['InstrumentoFinanciero']=$callApi->getQuanticoCF($host_lista_instrumento_financiero, $auth_encode);
            $resultado['listaValores']['TipoComision']=$callApi->getQuanticoCF($host_lista_comision, $auth_encode);
            $resultado['listaValores']['TipoCalculo']=$callApi->getQuanticoCF($host_lista_calculo, $auth_encode);
            $resultado['listaValores']['TipoTasa']=$callApi->getQuanticoCF($host_lista_tipo_tasa, $auth_encode);
        }

        return $resultado;

    }
}