<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetRelacionesNegocio extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETProductosAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('GetRelacionesNegocio', '?' ),
                'pathVars' => array('module', 'id' ),
                'method' => 'getRelRelaciones',
                'shortHelp' => 'Obtiene las relaciones de la cuenta',
            ),
        );
    }
    public function getRelRelaciones($api, $args)
    {
        try {
            //$GLOBALS['log']->fatal("args ",$args);
            $id = $args['id'];
            
            $records_in = [];
            $auxData = "";
            $queryProductos = "";
            $mensajeData = false;

            $query = "SELECT
            ra.rel_relaciones_accounts_1accounts_ida idCuenta,
            acstm.idcliente_c idCorto,
            a.name nombreCuenta,
            acstm.tipodepersona_c regimenFiscal,
            rc.id_c idRelacion,
            rc.account_id1_c idCuentaRelacionada,
            acstm2.idcliente_c idCortoRelacionada,
            r.name nombreCuentaRelacionada,
            acstm2.tipodepersona_c regimenFiscalRelacionada,
            r.relaciones_activas relacionesActivas,
            rc.relaciones_producto_c relacionesProducto
            FROM rel_relaciones_cstm rc
            INNER JOIN rel_relaciones r on r.id=rc.id_c AND r.deleted = 0
            INNER JOIN rel_relaciones_accounts_1_c ra on ra.rel_relaciones_accounts_1rel_relaciones_idb = rc.id_c AND ra.deleted = 0
            INNER JOIN accounts a on a.id = ra.rel_relaciones_accounts_1accounts_ida
            INNER JOIN accounts_cstm acstm on acstm.id_c = a.id
            INNER JOIN accounts_cstm acstm2 on acstm2.id_c = rc.account_id1_c
            WHERE ra.rel_relaciones_accounts_1accounts_ida='{$id}'";
            
            foreach ($args as $clave => $valor) {                
                if ($clave != '__sugar_url' && $clave != 'module' && $clave != 'id') {
                    $query .= " AND rc.relaciones_producto_c LIKE '%\"$clave\":\"{$valor}%'";
                }
            } 
            
            //$GLOBALS['log']->fatal("query++ ", $query);
            $result = $GLOBALS['db']->query($query);

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in[] = $row;
                $mensajeData = true;
            }

            //$GLOBALS['log']->fatal("records_in ",$records_in);
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
