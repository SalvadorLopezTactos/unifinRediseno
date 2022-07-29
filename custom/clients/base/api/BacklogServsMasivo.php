<?php
/**
 * @author: Tactos
 * @date: 28/07/2022
 * Se genera nuevo servicio para obtención de backlogs de forma masiva
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class BacklogServsMasivo extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_GetBacklogs' => array(
                'reqType' => 'POST',
                'path' => array('GetBacklogsMasivo'),
                'pathVars' => array(''),
                'method' => 'getBacklogsMasivo',
                'shortHelp' => 'Obtiene lista de Backlogs vigentes y comprometidos: Parámetros; idCliente, idBL, mesAnterior',
            ),
        );
    }

    public function getBacklogsMasivo ($api, $args){
        global $db, $current_user;
        $idCliente = isset($args['id']) ? $args['id'] : '';
        $BL = isset($args['bl']) ? $args['bl'] : '';
        $mesAnterior = isset($args['mesAnterior']) ? $args['mesAnterior'] : false;

        $query = "SELECT bl.id AS GUID, bl.numero_de_backlog AS noBacklog, bl.mes AS mes, bl.anio AS anio, estatus_de_la_operacion AS estatus, tipo AS tipo, IFNULL(monto_final_comprometido_c,0) AS monto, IFNULL(ri_final_comprometida_c,0) AS rentaInicial,
          IFNULL(bl.monto_real_logrado,0) AS montoReal, IFNULL(bl.renta_inicial_real,0) AS riReal, IFNULL(bl.monto_original,0) AS montoOriginal, bl.etapa AS etapa,
          IFNULL(cs.monto_prospecto_c,0) AS prospecto, IFNULL(cs.monto_credito_c,0) AS credito, IFNULL(cs.monto_rechazado_c,0) AS rechazada,
                IFNULL(cs.monto_sin_solicitud_c,0) AS sinSolicitud, IFNULL(cs.monto_con_solicitud_c,0) AS conSolicitud, IFNULL(monto_devuelta_c,0) AS montoDevuelta , IFNULL(cs.monto_pipeline_posterior_c,0) AS colocacionPipe,
          IFNULL(cs.ri_prospecto_c,0) AS riProspecto, IFNULL(cs.ri_credito_c,0) AS riCredito, IFNULL(cs.ri_rechazada_c,0) AS riRechazada, IFNULL(cs.ri_sin_solicitud_c,0) AS riSinSolicitud, IFNULL(cs.ri_con_solicitud_c,0) AS riConSolicitud
          FROM lev_backlog bl
          INNER JOIN lev_backlog_cstm cs ON bl.id = cs.id_c
          WHERE deleted = 0 and estatus_de_la_operacion = 'Comprometida' and tipo_de_operacion NOT IN ('Carga General')
        ";

        if($idCliente){
              $query .= " AND bl.account_id_c = '{$idCliente}'";
        }

        if($BL){
              $query .= " AND numero_de_backlog = '{$BL}'";
        }

        if($mesAnterior){
            //Recupera mes inmediato anterior y futuros
            $query .= " AND ( (mes >= MONTH( NOW() - INTERVAL 1 MONTH) and anio = YEAR(NOW() - INTERVAL 1 MONTH)) or (anio > YEAR(NOW())) )";
        }else{
            //Recupera mes actual y futuros
            $query .= " AND ((mes >= MONTH(NOW()) and anio = YEAR(NOW())) or (anio > YEAR(NOW())))";
        }

        $query .= ";";
        //$GLOBALS['log']->fatal('query: '. $query);
        $Backlogs = array();
        $rows = $db->query($query);
        while ($BackLog = $db->fetchByAssoc($rows)) {
            $Backlogs[] = array(
                "GUID" => $BackLog['GUID'],
                "noBacklog" => intval($BackLog['noBacklog']),
                "mes" => intval($BackLog['mes']),
                "anio" => intval($BackLog['anio']),
                "estatus" => $BackLog['estatus'],
                "tipo" => $BackLog['tipo'],
                "monto" => floatval($BackLog['monto']),
                "rentaInicial" => floatval($BackLog['rentaInicial']),
                "idCliente" => intval($BackLog['idCliente']),
                "montoReal" => floatval($BackLog['montoReal']),
                "riReal" => floatval($BackLog['riReal']),
                "montoOriginal" => floatval($BackLog['montoOriginal']),
                "montoDevuelta" => floatval($BackLog['montoDevuelta']),
                "etapa" => $BackLog['etapa'],
                "prospecto" => floatval($BackLog['prospecto']),
                "credito" => floatval($BackLog['credito']),
                "rechazada" => floatval($BackLog['rechazada']),
                "sinSolicitud" => floatval($BackLog['sinSolicitud']),
                "conSolicitud" => floatval($BackLog['conSolicitud']),
                "riProspecto" => floatval($BackLog['riProspecto']),
                "riCredito" => floatval($BackLog['riCredito']),
                "riRechazada" => floatval($BackLog['riRechazada']),
                "riSinSolicitud" => floatval($BackLog['riSinSolicitud']),
                "riConSolicitud" => floatval($BackLog['riConSolicitud']),
                "colocacionPipe" => floatval($BackLog['colocacionPipe'])
            );
        }

        return $Backlogs;
    }

}
