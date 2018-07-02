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
        try
        {
            $Etapa = 'Prospecto';
            $query = <<<SQL
    SELECT count(op.id)
	FROM Opportunities op
    INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
    INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
	WHERE acc_opp.account_id = '{$idCliente}'
	AND cs.tipo_producto_c =1
    AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
    AND cs.estatus_c IN ('R','CM')
SQL;
            $row = $db->getone($query);

            if($row > 0){
                $Etapa = 'Rechazada';
            }else{
                $query = <<<SQL
                SELECT count(op.id)
                FROM Opportunities op
                INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                WHERE acc_opp.account_id = '{$idCliente}'
                AND cs.tipo_producto_c =1
                AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                AND cs.estatus_c IN ('E','D','BC','EF','SC','RF','CC','RM')
SQL;
                $row = $db->getone($query);

                if($row > 0){
                    $Etapa = 'Credito';
                }
            }
            return $Etapa;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

    public function getBacklogs ($api, $args){
        global $db, $current_user;
        $idCliente = $args['id'];
        $BL = $args['bl'];

        $query = <<<SQL
            SELECT bl.id AS GUID, bl.numero_de_backlog AS noBacklog, bl.mes AS mes, bl.anio AS anio, estatus_de_la_operacion AS estatus, tipo AS tipo, IFNULL(monto_final_comprometido_c,0) AS monto, IFNULL(ri_final_comprometida_c,0) AS rentaInicial,
			IFNULL(bl.monto_real_logrado,0) AS montoReal, IFNULL(bl.renta_inicial_real,0) AS riReal, IFNULL(bl.monto_original,0) AS montoOriginal, bl.etapa AS etapa,
			IFNULL(cs.monto_prospecto_c,0) AS prospecto, IFNULL(cs.monto_credito_c,0) AS credito, IFNULL(cs.monto_rechazado_c,0) AS rechazada, IFNULL(cs.monto_sin_solicitud_c,0) AS sinSolicitud, IFNULL(cs.monto_con_solicitud_c,0) AS conSolicitud, IFNULL(cs.monto_pipeline_posterior_c,0) AS colocacionPipe,
			IFNULL(cs.ri_prospecto_c,0) AS riProspecto, IFNULL(cs.ri_credito_c,0) AS riCredito, IFNULL(cs.ri_rechazada_c,0) AS riRechazada, IFNULL(cs.ri_sin_solicitud_c,0) AS riSinSolicitud, IFNULL(cs.ri_con_solicitud_c,0) AS riConSolicitud
			FROM lev_backlog bl
			INNER JOIN lev_backlog_cstm cs ON bl.id = cs.id_c
			WHERE deleted = 0 and estatus_de_la_operacion = 'Comprometida' and tipo_de_operacion NOT IN ('Carga General')
			AND bl.account_id_c = '{$idCliente}' AND ((mes >= MONTH(NOW()) and anio = YEAR(NOW())) or (anio > YEAR(NOW())))

SQL;
        if($BL > 0){
            $query .= " and numero_de_backlog = {$BL}";
        }

        $rows = $db->query($query);

        if (mysqli_num_rows($rows) == 0){
            $Backlogs = array();
        }else {
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