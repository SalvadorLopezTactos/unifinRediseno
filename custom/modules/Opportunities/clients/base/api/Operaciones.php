<?php
/**
 * Created by PhpStorm.
 * User: Carlos Zaragoza
 * Date: 12/10/2015
 * Time: 13:28 hrs
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class Operaciones extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postOperaciones' => array(
                'reqType' => 'POST',
                'path' => array('Opportunities', 'Operaciones'),
                'pathVars' => array('',''),
                'method' => 'getOperacionesCount',
                'shortHelp' => 'Obtiene la cantidad de operaciones de un cliente',
            ),
        );
    }

    public function getOperacionesCount($api, $args)
    {
        $cuenta = $args['data']['id_c'];
        global $db;
        $query = <<<SQL
Select count(*) as cantidad from opportunities oc inner join
accounts_opportunities ao on ao.opportunity_id = oc.id
inner join accounts_cstm acs on acs.id_c = ao.account_id
where ao.account_id = '{$cuenta}' and oc.deleted = 0 and acs.tipo_registro_c = 'Prospecto'
SQL;
        $queryResult = $db->query($query);
        $cantidades = $db->fetchByAssoc($queryResult);
        return $cantidades;
    }

}

