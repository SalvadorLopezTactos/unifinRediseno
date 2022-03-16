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

                $query = "SELECT idCuenta,nombreCuenta,cuentas.idEmpresarial,cuentas.gpoEmpresarial,tipoCuenta,subtipoCuenta,idOpp,oppNombre,oppEtapa,
				monto,  fecha_asignacion,daypas, tipo_producto, EstatusProducto, val_dias_20,val_dias_10,
				CASE WHEN solicitudes.val_dias_20 = 20 and solicitudes.monto > 10000000 THEN 0
				WHEN solicitudes.val_dias_20 = -20 and solicitudes.monto > 10000000 THEN 1
				WHEN solicitudes.val_dias_10 = 10 and (solicitudes.monto <= 10000000 ) THEN 0
				WHEN solicitudes.val_dias_10 = -10 and (solicitudes.monto <= 10000000) THEN 1
				END AS semaforo
                    FROM (
	                    SELECT a.id as idCuenta, a.name as nombreCuenta,aGpo.id as idEmpresarial, aGpo.name as gpoEmpresarial, ac.user_id_c, ac.tipo_registro_c, up.tipo_cuenta as tipoCuenta,
                        up.subtipo_cuenta as subtipoCuenta,up.name nameProd, up.tipo_producto, upc.status_management_c as EstatusProducto
                        FROM accounts a
                        LEFT JOIN accounts aGpo on a.parent_id=aGpo.id
                        INNER JOIN accounts_cstm ac on ac.id_c = a.id
                        INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                        INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
                        INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                        WHERE up.tipo_cuenta = '2' and  up.subtipo_cuenta in ('8','10')
                        and ac.user_id_c = '{$id_user}'
                        and upc.status_management_c = '{$statusProduct}' -- '2'
                        and tipo_producto = '1'
                        and a.deleted = 0 and up.deleted = 0
                    ) AS cuentas LEFT JOIN (
                        SELECT app.account_id acc, opp.date_modified, TIMESTAMPDIFF(DAY, opp.date_modified, now()) as daypas,
                        opp.id as idOpp, opp.name as oppNombre, oppcstm.tipo_producto_c, opp.assigned_user_id oppassigned, oppcstm.tct_etapa_ddw_c, oppcstm.estatus_c,
                        oppcstm.tct_estapa_subetapa_txf_c as oppEtapa, DATE_FORMAT( opp.date_modified, '%Y-%m-%d ') as fecha_asignacion,
                        opp.amount as monto,
                        DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ')  as veinte,
                        DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ')  as diez,
                        CASE WHEN opp.date_modified <  DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ') THEN '20'
                        WHEN opp.date_modified >  DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ') THEN '-20'
                        END AS val_dias_20,
                        CASE WHEN opp.date_modified < DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ') THEN '10'
                        WHEN opp.date_modified > DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ') THEN '-10'
                        END AS val_dias_10
                        FROM accounts_opportunities app
                        INNER JOIN opportunities opp on opp.id = app.opportunity_id
                        INNER JOIN opportunities_cstm oppcstm on oppcstm.id_c = opp.id
						INNER JOIN (
		                	SELECT app.account_id uac, opp.id oppid, opp.name, max(opp.date_modified) as dayb , min(TIMESTAMPDIFF(DAY, opp.date_modified, now())) as daypas
		                	FROM accounts_opportunities app INNER JOIN opportunities opp on opp.id = app.opportunity_id
                            where  opp.assigned_user_id = '{$id_user}'
                            group by app.account_id order by app.account_id
                        ) AS ultimos on ultimos.uac = app.account_id and ultimos.dayb = opp.date_modified
				        WHERE  oppcstm.tipo_producto_c = '1'
                        group by app.account_id
                        order by daypas
			        ) as solicitudes
	            on cuentas.idCuenta = solicitudes.acc
                order by nombreCuenta asc";

                /*if ($statusProduct == '2') {
                    $query = $query . "where ( solicitudes.val_dias_20=20 and solicitudes.monto > 10000000) OR
                    ( solicitudes.val_dias_10=10 and (solicitudes.monto <= 10000000 and solicitudes.monto > 0))";
                }*/
                // $GLOBALS['log']->fatal('query ce',$query);
                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    $records_in['records'][] = array(
                        'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'],'idEmpresarial'=>$row['idEmpresarial'],'gpoEmpresarial'=>$row['gpoEmpresarial'] ,'tipoCuenta' => $row['tipoCuenta'],
                        'subtipoCuenta' => $row['subtipoCuenta'], 'idOpp' => $row['idOpp'], 'oppNombre' => $row['oppNombre'],
                        'oppEtapa' => $row['oppEtapa'], 'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $row['semaforo'],
                        'fecha_asignacion' => $row['fecha_asignacion'], 'Monto' => '$ ' . round($row['monto'], 2)
                    );
                }

            } else {
                $records_in['status'] = '200';
                $records_in['message'] = 'Validar que el estatus del Producto sea Activo o Aplazado';
            }
            //$GLOBALS['log']->fatal('records_in', $records_in);
            return $records_in;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
