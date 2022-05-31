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
        try
        {
            $Etapa = 'Prospecto';
            $query = <<<SQL
			SELECT count(op.id)
			FROM Opportunities op
			INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
			INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
			WHERE acc_opp.account_id = '{$idCliente}'
			AND cs.tipo_producto_c ='{$idProducto}'
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
                AND cs.tipo_producto_c ='{$idProducto}'
                AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                AND cs.estatus_c IN ('E','D','BC','EF','SC','RF','CC','RM')
SQL;
                $row = $db->getone($query);
                if($row > 0){
					$Etapa = 'Credito';
                } else {
					$query = <<<SQL
					SELECT count(op.id)
					FROM Opportunities op
					INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
					INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
					WHERE acc_opp.account_id = '{$idCliente}'
					AND cs.tipo_producto_c = '{$idProducto}'
					AND op.date_entered > date_add(NOW(), INTERVAL -12 MONTH)
					AND cs.estatus_c = 'N'
SQL;
					$row = $db->getone($query);
					if($row > 0){
						$Etapa = 'Autorizada';
					}else{
                        $query = <<<SQL
                        SELECT count(op.id)
                        FROM Opportunities op
                        INNER JOIN Opportunities_cstm cs ON cs.id_c = op.id
                        INNER JOIN accounts_opportunities acc_opp ON acc_opp.opportunity_id = op.id
                        WHERE acc_opp.account_id = '{$idCliente}'
                        AND cs.tipo_producto_c = '{$idProducto}'
                        AND op.date_entered > date_add(NOW(), INTERVAL -2 MONTH)
                        AND cs.estatus_c = 'DP'
SQL;
					    $row = $db->getone($query);
                        if($row > 0){
                            $Etapa = 'Devuelta'; // DP
                        }
                    }
				}
            }
            return $Etapa;
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }
}
