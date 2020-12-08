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
        $query = "SELECT
        case
            when up.tipo_producto = 1 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.tipo_cuenta = 1) then  
            1
            when up.tipo_producto = 3 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.tipo_cuenta = 1) then
            1
            when up.tipo_producto = 4 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.tipo_cuenta = 1) then
            1
            when up.tipo_producto = 6 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.tipo_cuenta = 1) then
            1
            when up.tipo_producto = 8 and (up.subtipo_cuenta = 2 or up.subtipo_cuenta = 7 or up.tipo_cuenta = 1) then
            1
            else 0
        end 'visible_noviable', up.*, upc.*, concat(u.first_name,' ',u.last_name) as full_name
        FROM accounts a
        inner join accounts_uni_productos_1_c ap on a.id = ap.accounts_uni_productos_1accounts_ida
        inner join uni_productos up on up.id = ap.accounts_uni_productos_1uni_productos_idb
        inner join uni_productos_cstm upc on upc.id_c = up.id
        inner join users u on u.id = up.assigned_user_id
        where a.id = '{$id}' and up.deleted = 0";

        $result = $GLOBALS['db']->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in[] = $row;
        }
        return $records_in;
    }
}
