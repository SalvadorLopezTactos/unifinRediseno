<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetRelacionesNegocio extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETProductosAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
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
            ////$GLOBALS['log']->fatal("args ",$args);
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
            
            $condiciones = false;
            $para = 0;
            foreach ($args as $clave => $valor) {                
                if ($clave != '__sugar_url' && $clave != 'module' && $clave != 'id') {
                    $condiciones = true;
                    $para ++;
                }
            }
            
            ////$GLOBALS['log']->fatal("query++ ", $query);
            //$GLOBALS['log']->fatal("para++ ", $para);
            $result = $GLOBALS['db']->query($query);
            $valortr = 0;
            $valok = 0;
            $para1 = 0;
            $auxrel = [];
            $relactivax = "";
            $arrelstr = "";
            $coincide = false;
            if($condiciones){
                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    $datatotal = json_decode ($row['relacionesProducto']);
                    ////$GLOBALS['log']->fatal("datajs ", $datajs);
                    //$GLOBALS['log']->fatal("datatotal: ", $datatotal);
                    foreach ($datatotal as $reg => $data) {  
                        $datajs = $data;
                        //$GLOBALS['log']->fatal("datajs++ ", $datajs);
                        foreach ($args as $clave => $valor) {
                            if ($clave != '__sugar_url' && $clave != 'module' && $clave != 'id') {    
                                $para1 ++;
                                foreach ($datajs as $claved => $valord) {  
                                    if($claved == 'rel'){
                                        $relactivax = $valord;
                                        //$GLOBALS['log']->fatal("relactivax++ ", $relactivax);
                                    }
                                    if ($claved == $clave) {
                                        //$GLOBALS['log']->fatal("clave: ". $clave.'--'.$valor);
                                        $resultado = str_replace("^", "", $valor);
                                        $aux  = explode(",", $resultado);
                                        foreach ($aux as $dataex) {
                                            $resultadox = str_replace("^", "", $valord);
                                            $auxx  = explode(",", $resultadox);
                                            foreach ($auxx as $datacompare) {
                                                //$GLOBALS['log']->fatal("aux++ ". $dataex.'-'.$datacompare);
                                                if($datacompare == $dataex){
                                                    $valortr ++;
                                                    $valok ++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //$GLOBALS['log']->fatal("coincidencias1: ". $valok.'-'.$para1);
                        if($valok >= $para1 && $valok > 0){
                            array_push($auxrel , $relactivax );
                            $coincide = true;
                        }
                        $para1 = 0;
                        $valok = 0;
                    }
                    //$GLOBALS['log']->fatal("grupi++ ". $valortr.'--'.$para);
                    //$GLOBALS['log']->fatal("auxrel: ", $auxrel);
                    //if($valortr >= $para && $valortr > 0){
                    if($coincide){
                        $mensajeData = true;
                        $arrelstr = implode("^,^", $auxrel);
                        $arrelstr = '^' . $arrelstr . '^';
                        //$GLOBALS['log']->fatal("arrelstr: ", $arrelstr);
                        $row['relacionesActivas'] = $arrelstr;
                        $records_in[] = $row;
                        $auxrel = [];
                        $coincide = false;
                    }
                    $valortr = 0;
                }
                //$records_in = unique_multidim_array($records_in,'idCuenta');
            }else{
                while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                    $records_in[] = $row;
                    $mensajeData = true;
                }
            }
            

            ////$GLOBALS['log']->fatal("records_in ",$records_in);
            if ($mensajeData) {
                return $records_in;
            } else {

                $mensaje = '{"error":"no_records","error_message":"No se encontraron datos, validar Id Cuenta, Relación Activa o Producto que sean correctos"}';
                $myJSON = json_decode($mensaje);
                $mensajeData = $myJSON;
            }
            return $mensajeData;

        } catch (Exception $e) {

            //$GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}
