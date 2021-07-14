<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetAccountProspectoContactado extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETAProspectoContactadoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetAccountProspectoContactado', '?'),
                'pathVars' => array('module', 'sproducto'),
                'method' => 'getcstmGetAccountProspectoContactado',
                'shortHelp' => 'Obtiene todas las Cuentas de tipo Prospecto Contactado que no tienen solicitudes',
            ),
        );
    }
    public function getcstmGetAccountProspectoContactado($api, $args)
    {

        try {

            global $current_user;
            $id_user = $current_user->id;
            $estadoProducto = $args['sproducto'];
            $records_in = [];

            if ($estadoProducto != 3) {
                //DASHLET PROSPECTO CONTACTADOS / SIN CONTACTAR 
                $query = "SELECT a.id as idCuenta, a.name as cuenta,aGpo.id as idEmpresarial, aGpo.name as gpoEmpresarial,ac.user_id_c, upc.fecha_asignacion_c as fechaAsignacion,
                up.tipo_cuenta as tipoCuenta, up.subtipo_cuenta as subtipoCuenta,
                up.name, upc.status_management_c as EstatusProducto, up.tipo_producto,
                CASE WHEN upc.fecha_asignacion_c < DATE_SUB(now(), INTERVAL 5 DAY) THEN 0
                WHEN upc.fecha_asignacion_c > DATE_SUB(now(), INTERVAL 5 DAY) THEN 1
                END AS semaforo
                FROM accounts a
                LEFT JOIN accounts aGpo on a.parent_id=aGpo.id
                INNER JOIN accounts_cstm ac on ac.id_c = a.id and a.deleted = 0
                INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c and aup.deleted = 0
                INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb and up.deleted = 0
                INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                WHERE
                up.tipo_cuenta = '2'
                and up.subtipo_cuenta in ('1','2')
                and ac.user_id_c = '{$id_user}'
                and up.tipo_producto = '1'
                and upc.status_management_c = '{$estadoProducto}'
                order by a.name asc ";

                /*if ($estadoProducto == 2) {
                    $query = $query . "and upc.fecha_asignacion_c < DATE_SUB(now(), INTERVAL 5 DAY)";
                }*/

                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {

                    $records_in['records'][] = array(
                        'idCuenta' => $row['idCuenta'], 'cuenta' => $row['cuenta'],'idEmpresarial' => $row['idEmpresarial'],'gpoEmpresarial'=>$row['gpoEmpresarial'], 'fechaAsignacion' => $row['fechaAsignacion'], 'tipoCuenta' => $row['tipoCuenta'],
                        'subtipoCuenta' => $row['subtipoCuenta'], 'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $row['semaforo']
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
