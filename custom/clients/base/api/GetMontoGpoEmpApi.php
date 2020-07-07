<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetMontoGpoEmpApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETMontoGpoEmpAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetMontoGpoEmpApi','?'),
                'pathVars' => array('module', 'id'),
                'method' => 'getMontoGpoEmpresarial',
                'shortHelp' => 'Obtiene los montos de las solicitudes por Grupo Empresarial, suma y obtiene el Total',
            ),
        );
    }
    public function getMontoGpoEmpresarial($api, $args)
    {

        try {

            $resultApi = array();
            $idCuenta = $args['id'];

            $beanCuenta = BeanFactory::retrieveBean('Accounts',$idCuenta,array('disable_row_level_security' => true));
            $parentID = empty($beanCuenta->parent_id)? $idCuenta : $beanCuenta->parent_id;
            $records_in = [];

            $query1 = "SELECT distinct id from accounts
            where id = '{$parentID}'
            or parent_id = '{$parentID}'";

            $result1 = $GLOBALS['db']->query($query1);
            $num_rows = $result1->num_rows;
            $resultApi['numCuentasGpoEmp'] = $num_rows;
            
            $query = "SELECT a.parent_id,a.name,ap.account_id,opp.id,opp.name,oppc.tipo_producto_c,oppc.monto_c as monto
            from accounts a
            inner join accounts_cstm ac on a.id = ac.id_c
            inner join accounts_opportunities ap on ac.id_c = ap.account_id
            inner join opportunities opp on opp.id = ap.opportunity_id AND opp.deleted=0
            inner join opportunities_cstm oppc on oppc.id_c = opp.id
            where (a.id = '{$parentID}' or a.parent_id = '{$parentID}')
            and oppc.estatus_c = 'N'";
            // $GLOBALS['log']->fatal("query ".$query);
            $result = $GLOBALS['db']->query($query);

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in[] = $row['monto'];
                $totalMonto = array_sum($records_in);
            }

            $resultApi['montoTotalGpoEmp'] = $totalMonto;
            return $resultApi;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
