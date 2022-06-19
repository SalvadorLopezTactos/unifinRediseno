<?php
/**
 * @author: Adrián Arauz
 * @date: 27/09/2021
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class BacklogServsProducto extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'BacklogServsProducto' => array(
                'reqType' => 'GET',
                'path' => array('BacklogServsProducto','getEtapa','?','?'),
                'pathVars' => array('', '', 'id','producto'),
                'method' => 'getEtapaProceso',
                'shortHelp' => 'Obtiene la lista de firmantes de un cliente añadiendo el filtro por tipo de producto.',
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
                	AND cs.tipo_producto_c = '{$idProducto}'
                	AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                	AND cs.estatus_c IN ('R','CM')
                union
                	SELECT 'credito' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '{$idProducto}'
                	AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                	AND cs.estatus_c IN ('E','D','BC','EF','SC','RF','CC','RM')
                union
                	SELECT 'autorizada' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '{$idProducto}'
                	AND op.date_entered > date_add(NOW(), INTERVAL -12 MONTH)
                	AND cs.estatus_c = 'N'
                union
                	SELECT 'devuelta' etapa, count(op.id) total
                	FROM Opportunities op
                	INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                	INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                	WHERE acc_opp.account_id = '{$idCliente}'
                	AND cs.tipo_producto_c = '{$idProducto}'
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
}
