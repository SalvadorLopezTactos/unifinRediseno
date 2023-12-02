<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class BuroCredito extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'ClientesSinBuroCredito' => array(
                'reqType' => 'GET',
                'path' => array('ClientesSinBuroCredito'),
                'pathVars' => array(''),
                'method' => 'getClientesSinBuroCredito',
                'shortHelp' => 'Obtiene cuentas tipo cliente que no cuentan con el check de Buró de Crédito',
            ),
            'ClientesBuroCredito' => array(
                'reqType' => 'GET',
                'path' => array('ClientesBuroCredito'),
                'pathVars' => array(''),
                'method' => 'getClientesBuroCredito',
                'shortHelp' => 'Obtiene cuentas tipo cliente que se encuentran marcadas para seguimiento de Buró de Crédito (campo seguimiento_bc_c)',
            ),
            'BorrarBuroCredito' => array(
                'reqType' => 'POST',
                'path' => array('BorrarClienteBuroCredito'),
                'pathVars' => array(''),
                'method' => 'deleteClientesBuroCredito',
                'shortHelp' => 'Elimina del seguimiento de buró de crédito la cuenta enviada como parámetro',
            ),
        );
    }

    public function getClientesSinBuroCredito($api, $args){
        $nameFiltro = $args['q'];
        $response = array();
        //Obtener todas las cuentas tipo Cliente que no tengan marcado el check de buró de Crédito (campo en resumen)
        $sqlQuery = "SELECT a.name, a.id ,ac.tipo_registro_cuenta_c, ac.subtipo_registro_cuenta_c, ac.rfc_c, rc.seguimiento_bc_c FROM accounts a 
INNER JOIN accounts_cstm ac ON a.id =ac.id_c
INNER JOIN tct02_resumen_cstm rc ON ac.id_c = rc.id_c
WHERE a.deleted = 0
AND ac.tipo_registro_cuenta_c = '3'
AND a.name LIKE '%".$nameFiltro."%'
AND (rc.seguimiento_bc_c = 0 OR rc.seguimiento_bc_c IS NULL);";

        $result = $GLOBALS['db']->query($sqlQuery);

        while($row = $GLOBALS['db']->fetchByAssoc($result)) {
			array_push($response,$row);
		}
        return $response;
    }

    public function getClientesBuroCredito($api, $args){
        $response = array();
        //Obtener todas las cuentas tipo Cliente que no tengan marcado el check de buró de Crédito (campo en resumen)
        $sqlQuery = "SELECT a.name, a.id ,ac.tipo_registro_cuenta_c, ac.subtipo_registro_cuenta_c, ac.rfc_c, rc.seguimiento_bc_c FROM accounts a 
INNER JOIN accounts_cstm ac ON a.id =ac.id_c
INNER JOIN tct02_resumen_cstm rc ON ac.id_c = rc.id_c
WHERE a.deleted = 0
AND ac.tipo_registro_cuenta_c = '3'
AND rc.seguimiento_bc_c = 1 ";

        $result = $GLOBALS['db']->query($sqlQuery);

        while($row = $GLOBALS['db']->fetchByAssoc($result)) {
			array_push($response,$row);
		}
        return $response;
    }

    public function deleteClientesBuroCredito($api, $args){

        $idCliente = $args['idCliente'];

        $beanResumen = BeanFactory::getBean('tct02_Resumen', $idCliente);

        $beanResumen->seguimiento_bc_c = 0;

        $beanResumen->save();

        return array(
            "msg"=>"El Cliente ".$beanResumen->name." ha sido removido del seguimiento de Buró de Crédito",
            "id"=> $idCliente
        );


    }

}

