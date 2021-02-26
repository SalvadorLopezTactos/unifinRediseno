<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetLeadsProspectoInteresado extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETLeadProspectoInteresadoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetLeadsProspectoInteresado', '?'),
                'pathVars' => array('module', 'statusProduct'),
                'method' => 'getcstmGetLeadsProspectoInteresado',
                'shortHelp' => 'Obtiene todas las Cuentas de tipo Prospecto Interesado con sus Solicitudes en estatus inicial',
            ),
        );
    }
    public function getcstmGetLeadsProspectoInteresado($api, $args)
    {

        try {

            global $current_user;
            $id_user = $current_user->id;
            $statusProduct = $args['statusProduct'];
            $records_in = [];

            if ($statusProduct != 3) {

                $query = "SELECT a.id as idCuenta, a.name as nombreCuenta, a.assigned_user_id, ac.user_id_c, ac.tipo_registro_c, ac.subtipo_cuenta_c, 
                ac.tipo_registro_cuenta_c as tipoCuenta, ac.subtipo_registro_cuenta_c as subtipoCuenta, opp.id as idOpp, opp.name as oppNombre, 
                opp.date_entered, opp.assigned_user_id, oppcstm.tct_etapa_ddw_c, oppcstm.tct_estapa_subetapa_txf_c as oppEtapa,
                up.name, upc.status_management_c as EstatusProducto, up.tipo_producto, oppcstm.tipo_producto_c, 
                CASE WHEN opp.date_entered < DATE_SUB(now(), INTERVAL 5 DAY) THEN 0
                WHEN opp.date_entered > DATE_SUB(now(), INTERVAL 5 DAY) THEN 1
                END AS semaforo
                FROM accounts a
                INNER JOIN accounts_cstm ac on ac.id_c = a.id and a.deleted = 0 
                INNER JOIN accounts_opportunities app on app.account_id = ac.id_c
                INNER JOIN opportunities opp on opp.id = app.opportunity_id
                INNER JOIN opportunities_cstm oppcstm on oppcstm.id_c = opp.id
                INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb and up.deleted = 0
                INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                WHERE ac.tipo_registro_cuenta_c = '2' and ac.subtipo_registro_cuenta_c = '7' and ac.user_id_c= '{$id_user}'
                and oppcstm.tct_etapa_ddw_c = 'SI' 
                and up.tipo_producto = '1' and oppcstm.tipo_producto_c = '1'
                and upc.status_management_c = '{$statusProduct}' ";

                if ($statusProduct == 2) {
                    $query = $query . "and opp.date_entered < DATE_SUB(now(), INTERVAL 5 DAY)";
                }
                // $GLOBALS['log']->fatal('query pi '. $query);
                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    
                    $records_in['records'][] = array(
                        'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'], 'tipoCuenta' => $row['tipoCuenta'],
                        'subtipoCuenta' => $row['subtipoCuenta'], 'idOpp' => $row['idOpp'], 'oppNombre' => $row['oppNombre'], 
                        'oppEtapa' => $row['oppEtapa'], 'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $row['semaforo']
                    );
                }

            } else {

                $records_in['status'] = '200';
                $records_in['message'] = 'Validar que el estatus del Producto sea Activo o Aplazado';
            }

            return $records_in;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
