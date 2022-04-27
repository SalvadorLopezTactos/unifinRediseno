<?php
/**
 * Created by PhpStorm.
 * User: Carlos Zaragoza
 * Date: 12/10/2015
 * Time: 13:28 hrs
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class CondicionesFinancieras extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postCondicionesFinancieras' => array(
                'reqType' => 'POST',
                'path' => array('Opportunities', 'CondicionesFinancieras'),
                'pathVars' => array('',''),
                'method' => 'getCondicionesFinancieras',
                'shortHelp' => 'Obtiene las condiciones financieras de un plazo + producto',
            ),

            'POST_GetCF_Opp' => array(
                'reqType' => 'GET',
                'path' => array('Opportunities', 'GetCondicionesFinancierasOpp','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'getCFList',
                'shortHelp' => 'Obtiene lista de Condiciones Financieras de una solicitud creada.',
            ),
        );
    }

    public function getCondicionesFinancieras($api, $args)
    {
        global $current_user;
        $plazo = $args['data']['plazo_c'];
        $producto = $args['data']['tipo_producto_c'];

        if($plazo == null){
            $plazo = $producto=="4"?30:12;
        }

        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : plazo: $plazo, producto: $producto");
        $porcentaje = 0;
        $vrc = 0;
        $vri = 0;
        $tasa = 0;
        $renta_inicial = 0;


        if($producto == "1"){
            //LEASING
            $tasa = 20;
            $porcentaje = 3;
            switch($plazo){
                case 12:
                    $vrc = 65;
                    $vri = 70;
                    $renta_inicial = 25;
                    break;
                case 24:
                    $vrc = 40;
                    $vri = 50;
                    $renta_inicial = 25;
                    break;
                case 36:
                    $vrc = 20;
                    $vri = 30;
                    $renta_inicial = 25;
                    break;
                case 48:
                    $vrc = 10;
                    $vri = 20;
                    $renta_inicial = 25;
                    break;
            }

        }elseif($producto == "3"){
            //Credito automotriz
            $tasa = 20;
            $porcentaje = 5;
            $renta_inicial = 20;

        }elseif($producto == "4"){
            //factoraje

            $porcentaje = 1;
            switch($plazo){
                case 30:
                    $tasa = 18;
                    break;
                case 60:
                    $tasa = 17;
                    break;
                case 90:
                    $tasa = 16;
                    break;
                case 120:
                    $tasa = 15;
                    break;
                case 150:
                    $tasa = 14;
                    break;
                case 180:
                    $tasa = 13;
                    break;
            }
        }

        $condiciones = array(
            "porcentaje_ca_c" => $porcentaje
            ,"ca_importe_enganche_c" => ""
            ,"vrc_c" => $vrc
            ,"vri_c" => $vri
            ,"ca_tasa_c" => $tasa
            ,"porcentaje_renta_inicial_c" => $renta_inicial
        );

        return $condiciones;
    }

    public function getCFList($api, $args) {
        global $db, $current_user, $app_list_strings;
        $idSolicitud = $args['id'];
        $list = $app_list_strings['idactivo_list'];

        $query = <<<SQL
            select opp_c.idsolicitud_c idSol,
            IFNULL(cf.idactivo,'000100030001') idactivo, IFNULL(cf.consecutivo,0) consecutivo,
            IFNULL(CF.plazo_minimo,0) PLAZO_min, IFNULL(CF.plazo_maximo,0) PLAZO_max,
            IFNULL(CF.tasa_minima,0) TASA,
            IFNULL(CF.vrc_minimo,0) VRC_min, IFNULL(CF.vrc_maximo,0) VRC_max, IFNULL(CF.vri_minimo,0) VRI_min, IFNULL(CF.vri_maximo,0) VRI_max,
            IFNULL(CF.comision_minima,0) CA_min, IFNULL(CF.comision_maxima,0) CA_max,
            IFNULL(CF.renta_inicial_minima,0) RI_min, IFNULL(CF.renta_inicial_maxima,0) RI_max,
            IFNULL(CF.deposito_en_garantia,0) DEPOSITO, IFNULL(CF.uso_particular,0) PARTICULAR, IFNULL(CF.uso_empresarial,0) EMPRESARIAL,
            IFNULL(CF.activo_nuevo,0) NUEVO, IFNULL(CF.activo_usado,0) USADO
            FROM unifin.Opportunities opp
            INNER JOIN unifin.Opportunities_cstm opp_c ON opp.id = opp_c.id_c
            INNER JOIN unifin.lev_condicionesfinancieras_opportunities_c rel ON rel.lev_condicionesfinancieras_opportunitiesopportunities_ida = opp.id and rel.deleted = 0
            INNER JOIN lev_condicionesfinancieras cf ON cf.id = rel.lev_condic7ff1ncieras_idb and cf.deleted = 0
            WHERE opp.deleted = 0 AND cf.deleted = 0 AND rel.deleted = 0
            AND tipo_operacion_c in (1,2) AND opp_c.idsolicitud_c = '{$idSolicitud}';
SQL;

        $rows = $db->query($query);

        if (mysqli_num_rows($rows) == 0){
            $CondicionesFinancieras = array();
        }else {
            while ($CF = $db->fetchByAssoc($rows)) {

                // Get Activo
                foreach($list as $key=>$value){
                    if($key == $CF['idactivo']){
                        $match_val = $value;
                    }
                }

                $CondicionesFinancieras[] = array(
                    "idactivo" => $CF['idactivo'],
                    "ACTIVO" => $match_val != '' ? $match_val : $CF['idactivo'],
                    "consecutivo" => intval($CF['consecutivo']),
                    "PLAZO_min" => intval($CF['PLAZO_min']),
                    "PLAZO_max" => intval($CF['PLAZO_max']),
                    "TASA" => floatval($CF['TASA']),
                    "VRC_min" => floatval($CF['VRC_min']),
                    "VRC_max" => floatval($CF['VRC_max']),
                    "VRI_min" => floatval($CF['VRI_min']),
                    "VRI_max" => floatval($CF['VRI_max']),
                    "CA_min" => floatval($CF['CA_min']),
                    "CA_max" => floatval($CF['CA_max']),
                    "RI_min" => floatval($CF['RI_min']),
                    "RI_max" => floatval($CF['RI_max']),
                    "DEPOSITO" => intval($CF['DEPOSITO']),
                    "PARTICULAR" => intval($CF['PARTICULAR']),
                    "EMPRESARIAL" => intval($CF['EMPRESARIAL']),
                    "NUEVO" => intval($CF['NUEVO']),
                    "USADO" => intval($CF['USADO'])
                );
            }
        }

        $CF_List = array("CondicionesFinancieras" => $CondicionesFinancieras);
        return $CF_List;

    }
}

