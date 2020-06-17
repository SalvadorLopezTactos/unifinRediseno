<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");

class Relaciones extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETProductosAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('Relaciones', '?', '?', '?'),
                'pathVars' => array('module', 'id', 'relacion', 'producto'),
                'method' => 'getRelProductos',
                'shortHelp' => 'Obtiene los productos de relaciones por producto en cuentas',
            ),
        );
    }
    public function getRelProductos($api, $args)
    {

        try {

            $id = $args['id'];
            $relacion = empty($args['relacion']) ? '0' : $args['relacion'];
            $relarray = preg_split("/\,/", $relacion);
            $producto = empty($args['producto']) ? '0' : $args['producto'];
            $records_in = [];
            $queryProductos = "";
            $mensajeData = false;

            for ($i = 0; $i < count($relarray); $i++) {

                if ($i == 0) {
                    $queryProductos .= "r.relaciones_activas LIKE '%{$relarray[$i]}%'";
                } else {
                    $queryProductos .= "OR r.relaciones_activas LIKE '%{$relarray[$i]}%'";
                }
            }
            // $GLOBALS['log']->fatal("queryProductos: ".$queryProductos);
            $query = "SELECT
            ra.rel_relaciones_accounts_1accounts_ida idCuenta,
            acstm.idcliente_c idCorto,
            a.name nombreCuenta,
            rc.id_c idRelacion,
            rc.account_id1_c idCuentaRelacionada,
            acstm2.idcliente_c idCortoRelacionada,
            r.name nombreCuentaRelacionada,
            r.relaciones_activas relacionesActivas,
            rc.relaciones_producto_c relacionesProducto
            FROM rel_relaciones_cstm rc
            INNER JOIN rel_relaciones r on r.id=rc.id_c AND r.deleted = 0
            INNER JOIN rel_relaciones_accounts_1_c ra on ra.rel_relaciones_accounts_1rel_relaciones_idb = rc.id_c AND ra.deleted = 0
            INNER JOIN accounts a on a.id = ra.rel_relaciones_accounts_1accounts_ida
            INNER JOIN accounts_cstm acstm on acstm.id_c = a.id
            INNER JOIN accounts_cstm acstm2 on acstm2.id_c = rc.account_id1_c
            WHERE ({$queryProductos})
            AND ra.rel_relaciones_accounts_1accounts_ida='{$id}'
            AND rc.relaciones_producto_c LIKE '%{$producto}%'";
            // $GLOBALS['log']->fatal("query ".$query);
            $result = $GLOBALS['db']->query($query);

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in[] = $row;
                $mensajeData = true;
            }

            if ($mensajeData) {
                return $records_in;
            } else {

                $mensaje = '{"error":"no_records","error_message":"No se encontraron datos, validar Id Cuenta, Relación Activa o Producto que sean correctos"}';
                $myJSON = json_decode($mensaje);
                $mensajeData = $myJSON;
            }
            return $mensajeData;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
