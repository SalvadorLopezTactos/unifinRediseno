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

            /*if($posicion_operativa == '^2^'){
                $users = $this->getusuarios($id_user, $posicion_operativa);
                $records = $this->dir_regional($users[0],$users[1]);
            }else{
                $records = $this->dir_equipo($id_user);
            }*/
            $records = $this->dataBacklog($id_user, $posicion_operativa);
           //$GLOBALS['log']->fatal("records: " , $records);
            return $records;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    public function dataBacklog($id_user,$posicion_operativa){
        $pos = strrpos($posicion_operativa, "2");
            
        $year = date("Y");
        $month = intval(date("m"));
        $values = [];
        while($month<13){
            array_push($values,strval($month));
            $month ++;
        }
        
        $year =date("Y");
        $month = intval(date("m"));
        $val = array('1','4');
       
        $sq1 = new SugarQuery();
        $sq1->select(array('id','name','mes','anio','progreso','etapa_c','monto_con_solicitud_c','monto_sin_solicitud_c','assigned_user_id','equipo'));
        $sq1->from(BeanFactory::newBean('lev_Backlog'));
        $sq1->where()->equals('etapa_c', '1');
        $sq1->where()->queryAnd()->equals('estatus_operacion_c', '2')->in('etapa_c', $val);
        $sq1->where()->queryAnd()->equals('anio',$year)->in('mes',$values);
        $sq1->where()->queryOr()->gt('monto_con_solicitud_c',0)->gt('monto_sin_solicitud_c',0);
        //$sugarQuery->where()->queryAnd()->equals('estatus_operacion_c', '2')->notEquals('etapa_c','5');
        //$sugarQuery->orderByRaw("lev_Backlog.monto_con_solicitud_c DESC");

        $sq2 = new SugarQuery();
        $sq2->select(array('id','name','mes','anio','progreso','etapa_c','monto_con_solicitud_c','monto_sin_solicitud_c','assigned_user_id','equipo'));
        $sq2->from(BeanFactory::newBean('lev_Backlog'));
        $sq2->where()->equals('etapa_c', '1');
        $sq2->where()->queryAnd()->equals('estatus_operacion_c', '2')->in('etapa_c', $val);
        $sq2->where()->equals('anio', ($year+1));
        $sq2->where()->queryOr()->gt('monto_con_solicitud_c',0)->gt('monto_sin_solicitud_c',0);
        
        $sqUnion = new SugarQuery();
        $sqUnion->union($sq1);
        $sqUnion->union($sq2);
        
        $result = $sqUnion->execute();
        
        /*$query = "SELECT bkl.id, bkl.name, bkl.anio, bkl.mes, bk1.etapa_c, IF(bkl.progreso=1,'Con Solicitud','Sin Solicitud') etapa, bk1.estatus_operacion_c,
        IF(bkl.progreso=1, bk1.monto_con_solicitud_c , bk1.monto_sin_solicitud_c ) monto 
                FROM lev_backlog bkl join  lev_backlog_cstm bk1 on bkl.id = bk1.id_c
                WHERE (bk1.monto_con_solicitud_c > 0 OR bk1.monto_sin_solicitud_c > 0) 
                and bk1.estatus_operacion_c = '2' and bk1.etapa_c in ('1','4')
                and ((bkl.anio = '2022' and bkl.mes in ('8','9','10','11','12'))  or (bkl.anio = '2023')
                    )
                order by anio desc, monto desc ";
        $result = $GLOBALS['db']->query($query);
        */
        //$GLOBALS['log']->fatal('result', $result);
        /*
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $GLOBALS['log']->fatal('row', $row['id']);
            $GLOBALS['log']->fatal('row', $row['name']);
        }
        */
        $records_in = [];
        $data = [];
        $d1 = [];
        $users = [];

        $labels = [];
        $aux_etq = [];
        $datas = [];
        $records = [];
        $colors = [];

        $arrusers = [];
        $equipos = [];

        foreach($result as $val){
            array_push($users,$val['assigned_user_id']);
        }
        foreach($result as $val){
            array_push($equipos,$val['equipo']);
        }

        $txtusers = "'".implode("','", $users)."'";
        $queryusuarios = "SELECT id, user_name, nombre_completo_c from users join users_cstm on users.id = users_cstm.id_c where id in ({$txtusers})";
        $usrres = $GLOBALS['db']->query($queryusuarios);
        while ($row = $GLOBALS['db']->fetchByAssoc($usrres)) {
            $v1 = array (
                'id' => $row['id'],
                'nombre' => $row['nombre_completo_c']
            );
            array_push($arrusers,$v1);
        }
        //$GLOBALS['log']->fatal("arrusers: " , $arrusers);

        $result = array_slice($result, 0, 30);

        foreach($result as $val){
            if ($pos  != '' ) { //valida usuario director regional
                $auxuser = $val['equipo'];
            }else{
                foreach($usrres as $u){
                    if($val['assigned_user_id'] == $u['id']){
                        $auxuser = $u['nombre_completo_c'];
                    }
                }
            }
            $solicitud = ($val['progreso'] == '1') ? "Con Solicitud": "Sin solicitud" ;
            $etapa = $val['etapa_c'];
            $monto = ($val['progreso'] == '1')? $val['monto_con_solicitud_c'] : $val['monto_sin_solicitud_c'] ;
            array_push($datas, array('usuario'=>$auxuser ,'etapa'=>$etapa ,'monto'=>$monto) );
            
            if($val['progreso'] == '1') array_push($colors, 'rgba(63, 191, 191)' ) ;
            if($val['progreso'] != '1') array_push($colors, 'rgba(63, 101, 191)' ) ; 
            
            $texto_monto = '$ '.number_format( $monto , 2);
            if ($pos  != '' ) {
                $tabaux = array(
                    'usuario' => $auxuser,
                    'etapa' => $etapa,
                    'solicitud' => $solicitud,
                    'monto' => $monto
                );
            }else{
                $tabaux = array(
                    'href' => '#lev_Backlog/'. $val['id'],
                    'backlog' => $val['name'],
                    'usuario' => $auxuser,
                    'etapa' => $etapa,
                    'solicitud' => $solicitud,
                    'monto' => $monto,
                    'text_monto' => $texto_monto,
                );
            }
            
            array_push($records,$tabaux);
        }
        foreach($records as $lbl){
            array_push($aux_etq,$lbl['usuario']);
        }
        $aux_etq = array_unique($aux_etq);
        foreach($aux_etq as $l){
            array_push($labels,$l);
        }

        $datas = $this->groupArray($datas,'etapa','datos');
        //$GLOBALS['log']->fatal("datas: " , $datas);
        rsort($datas);
        $auxds = [];
        $dataset = [];
        $conteo = 0;
        $totalesx=0;
        $etiqueta = '';
        foreach($datas as $d1){
            if($d1['etapa']==1){$etiqueta = 'Autorizada';}
            else{$etiqueta = 'Crédito';}
            $x=$d1['datos'];
            foreach($labels as $u){
                
                foreach($x as $d1){
                    if($d1['usuario'] == $u){
                        $conteo ++;
                        $totalesx = $totalesx + $d1['monto'];
                    }
                }
                $auxds= array(
                    'etapa' => $etiqueta,
                    'cantidad' => $conteo,
                    'monto' => $totalesx,
                );
                $conteo = 0;
                $totalesx = 0;
                array_push($dataset,$auxds);
                $auxds = [];
            }
        }
        $count = [];
        $tot = [];
        $dt = [];
        $dataset = $this->groupArray($dataset,'etapa','arr');
        //$GLOBALS['log']->fatal("dataset: " , $dataset);
        foreach($dataset as $ds1){
            //$GLOBALS['log']->fatal("ds1: " , $ds1);
            foreach($ds1['arr'] as $conjunto){
                array_push($count,$conjunto['cantidad']);
                array_push($tot,$conjunto['monto']);
            }
            array_push($dt,array('etapa' => $ds1['etapa'],'cantidad' => $count, 'monto' => $tot,));
            
        }
        //$GLOBALS['log']->fatal("dataset: " , $dt);
        /*if(count($datas) > 20){
            $datas = array_slice($datas, 0, 30);
        }*/
        
        $this->array_sort_by_column($records, 'monto');
        
        /*if(count($records) > 20){
            $records = array_slice($records, 0, 30);
        }*/
        $sumcredi1 = 0;
        $cantcredi1 = 0;
        $sumautoriz1 = 0;
        $cantautoriz1 = 0;
        $sumcredi2 = 0;
        $cantcredi2 = 0;
        $sumautoriz2 = 0;
        $cantautoriz2 = 0;
        $groupequi = [];
        $requipo = [];
        if ($pos  != '' ) {
            //$GLOBALS['log']->fatal("records: " , $records);
            foreach($labels as $equi){
                $letiqueta= $equi;
                foreach($records as $r1){
                    if($equi == $r1['usuario']){
                        if($r1['etapa'] == '1'){
                            if($r1['solicitud'] == 'Con Solicitud'){
                                $sumautoriz1 = $sumautoriz1 + $r1['monto'];
                                $cantautoriz1 ++;
                            }else{
                                $sumautoriz2 = $sumautoriz2 + $r1['monto'];
                                $cantautoriz2 ++;
                            }
                        }else{
                            if($r1['solicitud'] == 'Con Solicitud'){
                                $sumcredi1 = $sumcredi1 + $r1['monto'];
                                $sumcredi1 ++;
                            }else{
                                $sumcredi2 = $sumcredi2 + $r1['monto'];
                                $sumcredi2 ++;
                            }
                        }
                    }
                }
                if($cantautoriz1 > 0){
                    $groupequi= array(
                        'usuario' => $letiqueta,
                        'etapa' => '1',
                        'solicitud' => 'Con Solicitud',
                        'nbacklog' => $cantautoriz1,
                        'monto' => $sumautoriz1,
                        'text_monto' => '$ '.number_format( $sumautoriz1 , 2),
                    );
                    array_push($requipo,$groupequi);
                }
                
                if($cantautoriz2 > 0){
                    $groupequi= array(
                        'usuario' => $letiqueta,
                        'etapa' => '1',
                        'solicitud' => 'Sin Solicitud',
                        'nbacklog' => $cantautoriz2,
                        'monto' => $sumautoriz2,
                        'text_monto' => '$ '.number_format( $sumautoriz2 , 2),
                    );
                    array_push($requipo,$groupequi);
                }
                
                if($cantcredi1 > 0){
                    $groupequi= array(
                        'usuario' => $letiqueta,
                        'etapa' => '4',
                        'solicitud' => 'Con Solicitud',
                        'nbacklog' => $cantcredi1,
                        'monto' => $sumcredi1,
                        'text_monto' => '$ '.number_format( $sumcredi1 , 2),
                    );
                    array_push($requipo,$groupequi);
                }

                if($cantcredi2 > 0){
                    $groupequi= array(
                        'usuario' => $letiqueta,
                        'etapa' => '4',
                        'solicitud' => 'Sin Solicitud',
                        'nbacklog' => $cantcredi2,
                        'monto' => $sumcredi2,
                        'text_monto' => '$ '.number_format( $sumcredi2 , 2),
                    );
                    array_push($requipo,$groupequi);
                }
                $sumcredi1 = 0;
                $cantcredi1 = 0;
                $sumautoriz1 = 0;
                $cantautoriz1 = 0;
                $sumcredi2 = 0;
                $cantcredi2 = 0;
                $sumautoriz2 = 0;
                $cantautoriz2 = 0;
            }
            $records = $requipo;
        }

      
        $records_in = array(
            'labels' => $labels,
            'datas' => $dt,
            'records' => $records
        );
        $GLOBALS['log']->fatal("records_in: " , $records_in);
        return $records_in;
    }

    function groupArray($array,$groupkey,$newgroup){
        //$GLOBALS['log']->fatal('entro a agrupar '.$groupkey.' '.$newgroup);
        //$GLOBALS['log']->fatal('grouparray ',$array);
        if (count($array)>0){
     	    $keys = array_keys($array[0]);
     	    $removekey = array_search($groupkey, $keys);
            if ($removekey===false)
     		    return array("Clave \"$groupkey\" no existe");
     	    else
     		    unset($keys[$removekey]);

     	    $groupcriteria = array();
     	    $return=array();
     	    foreach($array as $value){
     		    $item=null;
     		    foreach ($keys as $key){
     			    $item[$key] = $value[$key];
     		    }
     	 	    $busca = array_search($value[$groupkey], $groupcriteria);
     		    if ($busca === false){
     			    $groupcriteria[]=$value[$groupkey];
     			    $return[]=array($groupkey=>$value[$groupkey],$newgroup=>array());
     			    $busca=count($return)-1;
     		    }
     		    $return[$busca][$newgroup][]=$item;
     	    }
     	    return $return;
        }else
     	    return array();
    }

    public function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
    
        array_multisort($sort_col, $dir, $arr);
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
