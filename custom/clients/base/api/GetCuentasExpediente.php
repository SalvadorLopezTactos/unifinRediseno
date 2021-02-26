<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetCuentasExpediente extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETLeadNoAtendidoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetCuentasExpediente', '?'),
                'pathVars' => array('module', 'statusProduct'),
                'method' => 'getcstmGetCuentasExpediente',
                'shortHelp' => 'Obtiene todas las Cuentas con estatus "Prospecto en Integración de Expediente"',
            ),
        );
    }
    public function getcstmGetCuentasExpediente($api, $args)
    {

        try {

            global $current_user;
            $id_user = $current_user->id;
            $statusProduct = $args['statusProduct'];
            $records_in = [];

            if ($statusProduct != 3) {

                $query = "SELECT idCuenta,nombreCuenta,tipoCuenta,subtipoCuenta,idOpp,oppNombre,oppEtapa,
                fecha_asignacion_c, monto, tipo_producto, EstatusProducto, val_dias,
                CASE WHEN DATOS_EXP.val_dias = 20 and DATOS_EXP.monto > 10000000 THEN 0
                WHEN DATOS_EXP.val_dias = -20 and DATOS_EXP.monto > 10000000 THEN 1 
                WHEN DATOS_EXP.val_dias = 10 and (DATOS_EXP.monto <= 10000000 and DATOS_EXP.monto > 0) THEN 0
                WHEN DATOS_EXP.val_dias = -10 and (DATOS_EXP.monto <= 10000000 and DATOS_EXP.monto > 0) THEN 1
                END AS semaforo
                FROM (
                    SELECT a.id as idCuenta, a.name as nombreCuenta, a.assigned_user_id accountassigned, ac.user_id_c,  
                    opp.id as idOpp, opp.name as oppNombre, opp.id,  ac.tipo_registro_c, ac.subtipo_cuenta_c, 
                    ac.tipo_registro_cuenta_c as tipoCuenta, ac.subtipo_registro_cuenta_c as subtipoCuenta,
                    opp.date_entered, opp.assigned_user_id oppassigned, oppcstm.tct_etapa_ddw_c,
                    oppcstm.tct_estapa_subetapa_txf_c as oppEtapa, up.name nameOpp , upc.fecha_asignacion_c , 
                    opp.amount as monto, up.tipo_producto, upc.status_management_c as EstatusProducto,
                    DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ')  as veinte, 
                    DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ')  as diez,
                    CASE WHEN upc.fecha_asignacion_c <  DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ') THEN '20'
                    WHEN upc.fecha_asignacion_c >  DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ') THEN '-20' 
                    WHEN upc.fecha_asignacion_c < DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ') THEN '10'
                    WHEN upc.fecha_asignacion_c > DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ') THEN '-10'
                    END AS val_dias
                    FROM accounts a 
                    INNER JOIN accounts_cstm ac on ac.id_c = a.id
                    INNER JOIN accounts_opportunities app on app.account_id = ac.id_c
                    INNER JOIN opportunities opp on opp.id = app.opportunity_id
                    INNER JOIN opportunities_cstm oppcstm on oppcstm.id_c = opp.id
                    INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                    INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
                    INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                    WHERE  ac.tipo_registro_cuenta_c = '2' and ac.subtipo_registro_cuenta_c = '8'
                    and ac.user_id_c=  '{$id_user}'
                    and upc.status_management_c = '{$statusProduct}'
                    and tipo_producto = '1'
                    and a.deleted = 0 and up.deleted = 0 
                ) as DATOS_EXP";
                // $GLOBALS['log']->fatal('query',$query);
                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    $records_in['records'][] = array(
                        'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'], 'tipoCuenta' => $row['tipoCuenta'],
                        'subtipoCuenta' => $row['subtipoCuenta'], 'idOpp' => $row['idOpp'], 'oppNombre' => $row['oppNombre'],
                        'oppEtapa' => $row['oppEtapa'], 'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $row['semaforo'],
                        'fecha_asignacion' => $row['fecha_asignacion_c'], 'Monto' => '$ ' . round($row['monto'], 2)
                    );
                }

            } else {

                $records_in['status'] = '200';
                $records_in['message'] = 'Validar que el estatus del Producto sea Activo o Aplazado';
            }
            $GLOBALS['log']->fatal('records_in', $records_in);
            return $records_in;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
