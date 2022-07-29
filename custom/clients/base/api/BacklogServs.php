<?php
/**
 * @author: CVV
 * @date: 25/07/2017
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class BacklogServs extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'BacklogServs' => array(
                'reqType' => 'GET',
                'path' => array('BacklogServs','getEtapa','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'getEtapaProceso',
                'shortHelp' => 'Obtiene la lista de firmantes de un cliente.',
            ),

            'POST_GetBacklogs' => array(
                'reqType' => 'POST',
                'path' => array('GetBacklogs'),
                'pathVars' => array(''),
                'method' => 'getBacklogs',
                'shortHelp' => 'Obtiene lista de Backlogs del cliente, vigentes y comprometidos',
            ),

            'POST_BacklogValidate' => array(
                'reqType' => 'POST',
                'path' => array('BacklogValidate'),
                'pathVars' => array(''),
                'method' => 'BacklogValidate',
                'shortHelp' => 'Valida si es un Backlog que puede asociarse a negociaciones',
            ),
        );
    }

    public function getEtapaProceso($api, $args)
    {
        global $db, $current_user;
        $idCliente = $args['id'];
        $idProducto = $args['producto'];
        $etapas = [];
        $etapa = 'Prospecto';
        try
        {
            //Ejecuta consulta para obtener solicitudes por etapa
            $query = "	SELECT 'rechazada' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '1'
                	AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                	AND cs.estatus_c IN ('R','CM')
                union
                	SELECT 'credito' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '1'
                	AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                	AND cs.estatus_c IN ('E','D','BC','EF','SC','RF','CC','RM')
                union
                	SELECT 'autorizada' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '1'
                	AND op.date_entered > date_add(NOW(), INTERVAL -12 MONTH)
                	AND cs.estatus_c = 'N'
                union
                	SELECT 'devuelta' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '1'
                	AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                	AND cs.estatus_c = 'DP'
                ;";
            $result = $db->query($query);

            //Itera resultado
            while ($row = $db->fetchByAssoc($result)){
                //Valida etapas
                if($row['etapa'] == 'rechazada' && $row['total']>0){
                    $etapas[]='Rechazada';
                }
                if($row['etapa'] == 'devuelta' && $row['total']>0){
                    $etapas[]='Devuelta';
                }
                if($row['etapa'] == 'credito' && $row['total']>0){
                    $etapas[]='Credito';
                }
                if($row['etapa'] == 'autorizada' && $row['total']>0){
                    $etapas[]='Autorizada';
                }
            }

            //Valida resultado
            if(in_array("Autorizada",$etapas)){
                $etapa = 'Autorizada';
            }
            if(in_array("Credito",$etapas)){
                $etapa = 'Credito';
            }
            if(in_array("Devuelta",$etapas)){
                $etapa = 'Devuelta';
            }
            if(in_array("Rechazada",$etapas)){
                $etapa = 'Rechazada';
            }

            return $etapa;
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

    public function getBacklogs ($api, $args){
        global $db, $current_user;
        $idCliente = isset($args['id']) ? $args['id'] : '';
        $BL = isset($args['bl']) ? $args['bl'] : '';
        $mesAnterior = isset($args['mesAnterior']) ? $args['mesAnterior'] : false;
        //$mes = isset($args['mes']) ? $args['mes'] : '';
        //$anio = isset($args['anio']) ? $args['anio'] : '';
        //$response="Sin resultados. Favor de agregar los parámetros ";

        $query = "SELECT bl.id AS GUID, bl.numero_de_backlog AS noBacklog, bl.mes AS mes, bl.anio AS anio, estatus_de_la_operacion AS estatus, tipo AS tipo, IFNULL(monto_final_comprometido_c,0) AS monto, IFNULL(ri_final_comprometida_c,0) AS rentaInicial,
          IFNULL(bl.monto_real_logrado,0) AS montoReal, IFNULL(bl.renta_inicial_real,0) AS riReal, IFNULL(bl.monto_original,0) AS montoOriginal, bl.etapa AS etapa,
          IFNULL(cs.monto_prospecto_c,0) AS prospecto, IFNULL(cs.monto_credito_c,0) AS credito, IFNULL(cs.monto_rechazado_c,0) AS rechazada,
                IFNULL(cs.monto_sin_solicitud_c,0) AS sinSolicitud, IFNULL(cs.monto_con_solicitud_c,0) AS conSolicitud, IFNULL(monto_devuelta_c,0) AS montoDevuelta , IFNULL(cs.monto_pipeline_posterior_c,0) AS colocacionPipe,
          IFNULL(cs.ri_prospecto_c,0) AS riProspecto, IFNULL(cs.ri_credito_c,0) AS riCredito, IFNULL(cs.ri_rechazada_c,0) AS riRechazada, IFNULL(cs.ri_sin_solicitud_c,0) AS riSinSolicitud, IFNULL(cs.ri_con_solicitud_c,0) AS riConSolicitud
          FROM lev_backlog bl
          INNER JOIN lev_backlog_cstm cs ON bl.id = cs.id_c
          WHERE deleted = 0 and estatus_de_la_operacion = 'Comprometida' and tipo_de_operacion NOT IN ('Carga General')
          AND bl.account_id_c = '{$idCliente}'
        ";

        if($mesAnterior){
            //Recupera mes inmediato anterior y futuros
            $query .= " AND ( (mes >= MONTH( NOW() - INTERVAL 1 MONTH) and anio = YEAR(NOW() - INTERVAL 1 MONTH)) or (anio > YEAR(NOW())) )";
        }else{
            //Recupera mes actual y futuros
            $query .= " AND ((mes >= MONTH(NOW()) and anio = YEAR(NOW())) or (anio > YEAR(NOW())))";
        }

        if($BL){
              $query .= " and numero_de_backlog = {$BL}";
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

    public function BacklogValidate ($api, $args){
        global $db, $current_user;
        $idCliente = $args['id'];
        $BL = $args['bl'];

        $query = <<<SQL
            SELECT bl.id AS GUID, bl.numero_de_backlog AS noBacklog, bl.mes AS mes, bl.anio AS anio
			FROM lev_backlog bl
			INNER JOIN lev_backlog_cstm cs ON bl.id = cs.id_c
			WHERE deleted = 0
			and estatus_de_la_operacion = 'Comprometida'
			AND bl.account_id_c = '{$idCliente}'
			AND bl.numero_de_backlog = {$BL}
			AND ((mes >= MONTH(NOW()) and anio = YEAR(NOW())) or (anio > YEAR(NOW())))
			order by bl.anio, bl.mes asc
			LIMIT 1
SQL;

        $rows = $db->query($query);

        if (mysqli_num_rows($rows) == 0){
            $Backlogs = array();
        }else {
            while ($BackLog = $db->fetchByAssoc($rows)) {
                $Backlogs = array(
                    "GUID" => $BackLog['GUID'],
                    "noBacklog" => intval($BackLog['noBacklog']),
                    "mes" => intval($BackLog['mes']),
                    "anio" => intval($BackLog['anio'])
                );
            }
        }
        return $Backlogs;
    }
}
