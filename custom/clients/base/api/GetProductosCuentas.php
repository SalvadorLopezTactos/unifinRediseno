<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

class GetProductosCuentas extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETActivoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetProductosCuentas', '?'),
                'pathVars' => array('module', 'id'),
                'method' => 'getcstmProductos',
                'shortHelp' => 'Obtiene todos los productos relacionados a la cuenta',
            ),
        );
    }
    public function getcstmProductos($api, $args)
    {

        $id = $args['id'];
        $records_in = [];

        /*****************SUBTIPO CUENTA = 2-Contactado or SUBTIPO CUENTA = 7-Interesado or TIPO CUENTA = 1-Lead**********/
        $query = "SELECT PRODUCTOS.*, concat(uassign.first_name,' ',uassign.last_name) as full_name
        ,concat(u1.first_name,' ',u1.last_name) as fullname_ingesta_c
        ,concat(u2.first_name,' ',u2.last_name) as fullname_validacion1_c
        ,concat(u3.first_name,' ',u3.last_name) as fullname_validacion2_c
        FROM (SELECT
            case
                when up.tipo_producto = 1 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                when up.tipo_producto = 3 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                when up.tipo_producto = 4 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                when up.tipo_producto = 6 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                when up.tipo_producto = 8 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.subtipo_cuenta = 1) then 1
                else 0
            end 'visible_noviable', up.*, upc.*
            FROM accounts a
            inner join accounts_uni_productos_1_c ap on a.id = ap.accounts_uni_productos_1accounts_ida
            inner join uni_productos up on up.id = ap.accounts_uni_productos_1uni_productos_idb
            inner join uni_productos_cstm upc on upc.id_c = up.id
            and a.id = '{$id}' and up.deleted = 0
         ) AS PRODUCTOS
            LEFT JOIN users AS uassign ON PRODUCTOS.assigned_user_id = uassign.id
            LEFT JOIN users AS u1 ON PRODUCTOS.user_id_c = u1.id
            LEFT JOIN users AS u2 ON PRODUCTOS.user_id1_c = u2.id
            LEFT JOIN users AS u3 ON PRODUCTOS.user_id2_c = u3.id ";

        $result = $GLOBALS['db']->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in[] = $row;
        }
        return $records_in;
    }
}
