<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Top20Backlog extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'Top20Backlog' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('Top20Backlog'),
                'pathVars' => array('module'),
                'method' => 'getTop20Backlog',
                'shortHelp' => 'Obtiene los primeros 20 registros de Backlog para Client Manager',
            ),
        );
    }
    public function getTop20Backlog($api, $args)
    {
        try {
            global $current_user;
            $id_user = $current_user->id;
            $records_in = [];
            $query = "SELECT us2.nombre_completo_c usuario, IF(bkl.progreso=1,'Con','Sin') etapa, IF(bkl.progreso=1,FORMAT(SUM(bk1.monto_con_solicitud_c),2),FORMAT(SUM(bk1.monto_sin_solicitud_c),2)) monto 
FROM lev_backlog bkl, lev_backlog_cstm bk1, users us1, users_cstm us2, users us3, users_cstm us4 WHERE bkl.id = bk1.id_c AND bkl.assigned_user_id = us1.id 
AND us1.id = us2.id_c AND bkl.deleted = 0 AND (bk1.monto_con_solicitud_c > 0 OR bk1.monto_sin_solicitud_c > 0) 
AND us1.deleted = 0 AND us3.id = us4.id_c AND us3.deleted = 0 AND us2.nombre_completo_c <> '' AND us4.posicion_operativa_c = '^1^' 
AND us1.reports_to_id = '{$id_user}' GROUP BY usuario, bkl.progreso ORDER BY usuario, monto LIMIT 20;";
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
				$records_in['labels'][] = $row['usuario'];
				$records_in['datas'][] = str_replace(',', '', $row['monto']);
				if($row['etapa'] == 'Con') $records_in['colors'][] = 'rgba(255, 99, 132)';
				if($row['etapa'] == 'Sin') $records_in['colors'][] = 'rgba(255, 159, 64)';
                $records_in['records'][] = array(
                    'usuario' => $row['usuario'],
                    'etapa' => $row['etapa'],
                    'monto' => $row['monto'],
                );
            }
            return $records_in;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
