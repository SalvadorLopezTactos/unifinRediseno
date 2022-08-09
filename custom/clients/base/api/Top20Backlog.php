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
            $posicion_operativa = $current_user->posicion_operativa_c;

            if($posicion_operativa == '^2^'){
                $users = $this->getusuarios($id_user, $posicion_operativa);
                $records = $this->dir_regional($users[0],$users[1]);
            }else{
                $records = $this->dir_equipo($id_user);
            }
           $GLOBALS['log']->fatal("records: " , $records);
            return $records;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    public function dir_equipo($id_user){

        $records_in = [];
        try {
            $query = "SELECT us2.nombre_completo_c usuario, IF(bkl.progreso=1,'Con Solicitud','Sin Solicitud') etapa, IF(bkl.progreso=1,FORMAT(SUM(bk1.monto_con_solicitud_c),2),FORMAT(SUM(bk1.monto_sin_solicitud_c),2)) monto 
        FROM lev_backlog bkl, lev_backlog_cstm bk1, users us1, users_cstm us2, users us3, users_cstm us4 WHERE bkl.id = bk1.id_c AND bkl.assigned_user_id = us1.id 
        AND us1.id = us2.id_c AND bkl.deleted = 0 AND (bk1.monto_con_solicitud_c > 0 OR bk1.monto_sin_solicitud_c > 0) 
        AND us1.deleted = 0 AND us3.id = us4.id_c AND us3.deleted = 0 AND us2.nombre_completo_c <> '' AND us4.posicion_operativa_c = '^1^' 
        AND us1.reports_to_id = '{$id_user}' GROUP BY usuario, bkl.progreso ORDER BY usuario, monto LIMIT 20;";

            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['labels'][] = $row['usuario'];
                $records_in['datas'][] = str_replace(',', '', $row['monto']);
                if($row['etapa'] == 'Con Solicitud') $records_in['colors'][] = 'rgba(255, 99, 132)';
                if($row['etapa'] == 'Sin Solicitud') $records_in['colors'][] = 'rgba(255, 159, 64)';
                $records_in['records'][] = array(
                    'usuario' => $row['usuario'],
                    'etapa' => $row['etapa'],
                    'monto' => $row['monto'],
                    'text_monto' => '$  '. $row['monto'],
                );
            }
            //$GLOBALS['log']->fatal("records_in: " , $records_in);
            return $records_in;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
            return [];
        }
    }

    public function dir_regional($uids,$nombres){

        $labels = [];
        $datas = [];
        $records = [];
        $colors = [];
        
        for ($i = 0; $i < count($uids); $i++) {
            $res = $this->dir_equipo($uids[$i]);
            //$GLOBALS['log']->fatal("res: " , $res);

            if(!empty($res)){
                array_push($labels,$nombres[$i]);
                array_push($labels,$nombres[$i]);
                $cons = 0.0;
                $sins = 0.0;
                $dd = $res['records'];
                for ($j = 0; $j < count($dd); $j++) {
                    $mto = floatval(str_replace(',','',$dd[$j]['monto']));
                    if($dd[$j]['etapa'] == 'Con Solicitud'){
                        $cons += $mto;
                    }
                    if($dd[$j]['etapa'] == 'Sin Solicitud'){
                        $sins += $mto;
                    }
                }
                array_push($datas,$cons);
                array_push($colors,'rgba(255, 99, 132)');
                array_push($datas,$sins);
                array_push($colors,'rgba(255, 159, 64)');
                
                $aux = array(
                    'usuario' => $nombres[$i],
                    'etapa' => 'Con Solicitud',
                    'monto' => $cons,
                    'text_monto' => '$'.number_format( $cons , 2),
                );
                $aux1 = array(
                    'usuario' => $nombres[$i],
                    'etapa' => 'Sin Solicitud',
                    'monto' => $sins,
                    'text_monto' => '$'.number_format( $sins , 2),
                );
                array_push($records,$aux);
                array_push($records,$aux1);
            }
        }
        
        $salida = array(
            'labels' => $labels,
            'datas' => $datas,
            'colors' => $colors,
            'records' => $records
        );
        return $salida;
    }

    public function getusuarios($id_user , $posicion_operativa){
        $usuario = [];
        $nombre = [];

        $pos = strrpos($posicion_operativa, "2");
        if ($pos != "") { //valida usuario director equipo

            $queryusuarios = "SELECT u.id, uc.nombre_completo_c usuario, u.user_name,uc.equipos_c, uc.region_c 
            from users u join users_cstm uc on u.id = uc.id_c
            WHERE reports_to_id = '{$id_user}' 
                and u.status = 'Active' and u.deleted = 0 
                -- and uc.posicion_operativa_c like '%1%' 
            ";

            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                array_push($usuario,$row['id']);
                array_push($nombre,$row['usuario']);
            }
        }
        return array ($usuario,$nombre);
    }

}
