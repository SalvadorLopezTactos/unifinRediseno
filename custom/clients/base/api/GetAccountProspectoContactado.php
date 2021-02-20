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

                $query = "SELECT a.id as idCuenta, a.name as nombreCuenta, a.assigned_user_id, ac.user_id_c, ac.tipo_registro_c, ac.subtipo_cuenta_c, 
                ac.tipo_registro_cuenta_c as tipoCuenta, ac.subtipo_registro_cuenta_c as subtipoCuenta, 
                up.name, upc.status_management_c as EstatusProducto, up.tipo_producto
                FROM accounts a
                INNER JOIN accounts_cstm ac on ac.id_c = a.id
                LEFT JOIN accounts_opportunities app on app.account_id = ac.id_c
                INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
                INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                WHERE app.id IS NULL 
                and ac.tipo_registro_cuenta_c = '2' 
                and ac.subtipo_registro_cuenta_c = '2' 
                and ac.user_id_c = '{$id_user}'
                and upc.fecha_asignacion_c < DATE_SUB(now(), INTERVAL 5 DAY)
                and up.tipo_producto = '1'
                and upc.status_management_c = '{$estadoProducto}'
                and a.deleted = 0 and up.deleted = 0";

                $result = $GLOBALS['db']->query($query);

                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    
                    $records_in['records'][] = array(
                        'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'], 'tipoCuenta' => $row['tipoCuenta'],
                        'subtipoCuenta' => $row['subtipoCuenta'], 'EstatusProducto' => $row['EstatusProducto']
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
