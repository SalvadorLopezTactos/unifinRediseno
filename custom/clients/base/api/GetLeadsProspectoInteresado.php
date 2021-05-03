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
                //DASHLET SOLICITUDES SIN PROCESO
                $query = "SELECT
                cuentas.id as idCuenta, cuentas.name as nombreCuenta, cuentas.assigned_user_id, cuentas.user_id_c,
                cuentas.tipo_cuenta as tipoCuenta, cuentas.subtipo_cuenta as subtipoCuenta, solicitudes.idOpp as idOpp, solicitudes.oppNombre as oppNombre,
                solicitudes.date_modified, solicitudes.daypas, solicitudes.tct_etapa_ddw_c, solicitudes.tct_estapa_subetapa_txf_c as oppEtapa,
                cuentas.status_management_c as EstatusProducto, cuentas.tipo_producto, solicitudes.tipo_producto_c,
                CASE WHEN solicitudes.date_modified < DATE_SUB(now(), INTERVAL 5 DAY) THEN 0
                WHEN solicitudes.date_modified > DATE_SUB(now(), INTERVAL 5 DAY) THEN 1
                END AS semaforo
                    FROM
                    (SELECT a.id, a.name ,a.assigned_user_id, ac.user_id_c, ac.tipo_registro_c, up.tipo_cuenta,
                          up.subtipo_cuenta,up.name nameProd, up.tipo_producto, upc.status_management_c
                          FROM accounts a
                          INNER JOIN accounts_cstm ac on ac.id_c = a.id
                          INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                          INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
                          INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                          WHERE
                          up.tipo_cuenta = '2' and  up.subtipo_cuenta in ('7')
                          and ac.user_id_c in '{$id_user}'
                          and upc.status_management_c = '{$statusProduct}'
                          and tipo_producto = '1'
                          and a.deleted = 0 and up.deleted = 0
                    ) AS cuentas
                    LEFT JOIN
                    (SELECT
                            app.account_id acc, opp.date_modified, TIMESTAMPDIFF(DAY, opp.date_modified, now()) as daypas,
                            opp.id as idOpp, opp.name as oppNombre, oppcstm.tipo_producto_c, opp.assigned_user_id oppassigned, 
                            oppcstm.tct_etapa_ddw_c, oppcstm.estatus_c,	oppcstm.tct_estapa_subetapa_txf_c, opp.amount as monto
                        FROM accounts_opportunities app
                        INNER JOIN opportunities opp on opp.id = app.opportunity_id
                        INNER JOIN opportunities_cstm oppcstm on oppcstm.id_c = opp.id
                        INNER JOIN (
                            SELECT app.account_id uac, opp.id oppid, opp.name, max(opp.date_modified) as dayb , min(TIMESTAMPDIFF(DAY, opp.date_modified, now())) as daypas
                            FROM accounts_opportunities app INNER JOIN opportunities opp on opp.id = app.opportunity_id
                            where  opp.assigned_user_id in '{$id_user}'
                            group by app.account_id order by app.account_id
                        ) AS ultimos on ultimos.uac = app.account_id and ultimos.dayb = opp.date_modified
                    WHERE
                    oppcstm.tipo_producto_c = '1' 
                    and opp.assigned_user_id in '{$id_user}'
                    group by app.account_id
                    order by app.account_id
                    ) as solicitudes
                on cuentas.id = solicitudes.acc
                order by date_modified asc";

                /*if ($statusProduct == 2) {
                    $query = $query . "and opp.date_entered < DATE_SUB(now(), INTERVAL 5 DAY)";
                }*/
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
