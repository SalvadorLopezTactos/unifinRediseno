<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 12/08/20
 * Time: 05:00 PM
 */


class customGetOpportunities extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'POST_Opportunities' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('getOpportunities'),
                'pathVars' => array(''),
                'method' => 'getOpportunities',
                'shortHelp' => 'Consulta oportunidades de la cuenta',
            ),
        );
    }


    public function getOpportunities($api, $args)
    {
        global $db;
        $accountId = $args['data']['account_id'];
        $prouctId = $args['data']['tipo_producto_c'];
        $duplicado = 0;
        $mensaje = "";

        $queryData = "SELECT
  uni_cstm.multilinea_c,
  op_cstm.estatus_c,
  op_cstm.tct_etapa_ddw_c,
  op_cstm.tipo_producto_c
FROM opportunities_cstm op_cstm
  INNER JOIN accounts_opportunities op_rel
    ON op_rel.opportunity_id = op_cstm.id_c
  INNER JOIN accounts_uni_productos_1_c uni_rel
    ON uni_rel.accounts_uni_productos_1accounts_ida = op_rel.account_id
  INNER JOIN uni_productos uni
    ON uni.id = uni_rel.accounts_uni_productos_1uni_productos_idb
       AND uni.tipo_producto = '{$prouctId}'
  INNER JOIN uni_productos_cstm uni_cstm
    ON uni_cstm.id_c = uni.id
WHERE op_rel.account_id = '{$accountId}' AND op_cstm.tipo_producto_c = '{$prouctId}' AND op_rel.deleted = 0";

        $result = $db->query($queryData);

       // $GLOBALS['log']->fatal("Del query " .$result->num_rows );

        while ($row = $db->fetchByAssoc($result)) {
            $estatus = $row['estatus_c'];
            $etapa_ddw = $row['tct_etapa_ddw_c'];
            $tipo_producto = $row['tipo_producto_c'];
            $multilinea = $row['multilinea_c'];

            if ($estatus != "K" && $etapa_ddw != "CL" && $etapa_ddw != "R" ) {
                $mensaje = "No es posible crear una Pre-solicitud cuando ya se encuentra una Pre-solicitud o Solicitud en proceso.";
                $duplicado = 1;

            }elseif ($etapa_ddw == "CL" && ($tipo_producto == "1" || $tipo_producto == "4") && $multilinea !="1") {

                $mensaje = "No es posible crear una Pre-solicitud cuando ya se tiene una línea de crédito autorizada.";
                $duplicado = 1;
            }

        }

        $respuesta=["duplicado"=>$duplicado,"mensaje"=>$mensaje];
        return $respuesta;
    }


}