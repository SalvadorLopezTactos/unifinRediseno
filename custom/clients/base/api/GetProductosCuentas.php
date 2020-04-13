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

        $query = "SELECT
        case
            when up.tipo_producto = 1 and (rc.tct_subtipo_l_txf_c = 'Contactado' or rc.tct_subtipo_l_txf_c = 'Interesado'  or rc.tct_tipo_l_txf_c = 'Lead')  then
            1
            when up.tipo_producto = 3 and (rc.tct_subtipo_ca_txf_c = 'Contactado' or rc.tct_subtipo_ca_txf_c = 'Interesado'  or rc.tct_tipo_ca_txf_c = 'Lead' ) then
            1
            when up.tipo_producto = 4 and (rc.tct_subtipo_f_txf_c = 'Contactado' or rc.tct_subtipo_f_txf_c = 'Interesado'  or rc.tct_tipo_f_txf_c = 'Lead' ) then
            1
            when up.tipo_producto = 6 and (rc.tct_subtipo_fl_txf_c = 'Contactado' or rc.tct_subtipo_fl_txf_c = 'Interesado'  or rc.tct_tipo_fl_txf_c = 'Lead' ) then
            1
            when up.tipo_producto = 8 and (rc.tct_subtipo_uc_txf_c = 'Contactado' or rc.tct_subtipo_uc_txf_c = 'Interesado'  or rc.tct_tipo_uc_txf_c = 'Lead' ) then
            1
            else 0
        end 'visible_noviable', up.*, upc.*, concat(u.first_name,' ',u.last_name) as full_name
        FROM accounts a
        inner join accounts_uni_productos_1_c ap on a.id = ap.accounts_uni_productos_1accounts_ida
        inner join uni_productos up on up.id = ap.accounts_uni_productos_1uni_productos_idb
        inner join uni_productos_cstm upc on upc.id_c = up.id
        inner join users u on u.id = up.assigned_user_id
        inner join tct02_resumen_cstm rc on rc.id_c = a.id
        where
        a.id = '{$id}' and up.deleted = 0";

        $result = $GLOBALS['db']->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in[] = $row;
        }
        return $records_in;
    }
}
