<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetClientManager_Backlog extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetClientManager_Backlog_API' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetClientManager_BacklogTabla','?'),
                'pathVars' => array('module','id'),
                'method' => 'getDetalleSumaBacklog',
                'shortHelp' => 'Obtiene la suma de cantidades para backlog',
            ),
        );
    }
    public function getDetalleSumaBacklog($api, $args){

        try {
            global $current_user;
            $id_user = $current_user->id;
            $posicion_operativa = $current_user->posicion_operativa_c;
            $equipo_c = $current_user->equipo_c;

            //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
            //$GLOBALS['log']->fatal('id_user', $id_user.' - '.$current_user->user_name);
            //$GLOBALS['log']->fatal('equipo_c', $id_user.' - '.$current_user->equipo_c);
            
            $records = [];
            $records_totales = [];

            $pos = strrpos($posicion_operativa, "3");
            //$GLOBALS['log']->fatal('pos', $pos);

            $records=$this->getTotalesQuery();
            /*
            if($pos != ""){
                $records = $this->getTotalesAsesor( "'".$id_user."'" , "'".$equipo_c."'");
                $GLOBALS['log']->fatal('records', $records);
            }else{
                
                list ($usuarios, $equipo , $reg) = $this->getusuarios($id_user , $posicion_operativa);
                $GLOBALS['log']->fatal('usuarios', $usuarios);
                $GLOBALS['log']->fatal('equipo', $equipo);
                $GLOBALS['log']->fatal('reg', $reg);

                $records = $this->getTotales( $usuarios ,  $equipo );
            }*/
            
            //$GLOBALS['log']->fatal('records2-json', json_encode($records));
            $GLOBALS['log']->fatal('records', $records);
            return $records;
        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    
    public function getusuarios($id_user , $posicion_operativa){
        $usuario = [];
        $equipo = [];
        $region = [];
        $tteams ="";
        $usuarios = "";

        /*$sqlteams = "SELECT REPLACE(uc.equipos_c,'^','\'') AS equipos from users_cstm uc WHERE id_c = '{$id_user}'";
        $GLOBALS['log']->fatal('sqlteams', $sqlteams);

        $result = $GLOBALS['db']->query($sqlteams);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $tteams = $row['equipos'];
        }*/
        //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
        //$GLOBALS['log']->fatal('tteams', $tteams);
        
        $pos = strrpos($posicion_operativa, "1");
        if ($pos != "") { //valida usuario director equipo
            /*$queryusuarios = "SELECT u.id, u.user_name, uc.puestousuario_c, uc.equipo_c, uc.equipos_c, uc.region_c from users u
            join users_cstm uc on u.id = uc.id_c where -- uc.equipo_c in ({$tteams})
            and posicion_operativa_c like '%3%'  and u.status = 'Active' and u.status = 'Active' order by equipo_c";*/

            $queryusuarios = "SELECT u.id, u.user_name,uc.equipos_c, uc.region_c 
            from users u join users_cstm uc on u.id = uc.id_c
            WHERE reports_to_id = '{$id_user}' and u.status = 'Active'";

            //$GLOBALS['log']->fatal('queryusuarios-2-', $queryusuarios);
            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //array_push($usuario,$row['id']);
                $usuarios .= "'". $row['id'] . "',";
                array_push($equipo,$row['equipo_c']);
                array_push($region,$row['region_c']);
            }
        }
        
        $pos = strrpos($posicion_operativa, "2");
        //$GLOBALS['log']->fatal('pos', $pos);

        if ($pos != "") { //valida usuario director regional
            $usuariosin ="";
            $equipos_director = [];
            $equipomu = "SELECT REPLACE(uc.equipos_c,'^','\'') as equipos2
            from users_cstm uc where id_c in (
                select id -- , user_name, puestousuario_c , posicion_operativa_c , region_c , equipo_c, reports_to_id
                from users join users_cstm on users.id = users_cstm.id_c where
                equipo_c in ($tteams)  and  posicion_operativa_c like '%1%' and users.status = 'Active' )";
            //$GLOBALS['log']->fatal('equipomu', $equipomu);
            $result = $GLOBALS['db']->query($equipomu);
            //$GLOBALS['log']->fatal('result', $result);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                array_push($equipos_director,$row['equipos2']);
            }
            //$GLOBALS['log']->fatal('equipos_director', $equipos_director);
            $equiposf = [];
            foreach ($equipos_director as $key => $value) {
                $porciones = explode(",", $value);
                //$GLOBALS['log']->fatal('porciones', $porciones);
                $equiposf = array_merge($equiposf , $porciones);
            }
            $equiposf = array_unique($equiposf);
            //$GLOBALS['log']->fatal('equiposf', $equiposf);

            $salidaequipos = implode(",", $equiposf);
            $rest = substr($salidaequipos, -1);
            if($rest == ','){
                $salidaequipos = substr($casalidaequiposdena, 0, -1);
            }
            $queryusuarios = "SELECT id, user_name, puestousuario_c,equipo_c,equipos_c,region_c from users
            join users_cstm on users.id = users_cstm.id_c where equipo_c in
            ( {$salidaequipos} ) and posicion_operativa_c like '%3%'  and users.status = 'Active'
             order by equipo_c";
            //$GLOBALS['log']->fatal('queryusuarios', $queryusuarios);
            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //array_push($usuario,$row['id']);
                $usuarios .= "'".$row['id'] . "',";
                array_push($equipo,$row['equipo_c']);
                array_push($region,$row['region_c']);
            }
        }
        
        //$usuario = array_unique($usuario);
        //$usuario = array('usuario' => $usuario);
        $usuarios = substr($usuarios,0,-1);
        $equipo = array_unique($equipo);
        $equipo = array('equipo' => $equipo);
        $region = array_unique($region);
        $region = array('region' => $region);

        return array($usuarios, $tteams, $region);
    }
    
    public function getTotales($idUsuario, $equipos){
        $queryAgrupado = "SELECT  IF(lbc.etapa_c = '1', 'Autorizado' ,  'En proceso' ) as filtro, lbc.etapa_solicitud_c ,  lbc.etapa_c as etapa , lb.progreso as solicitud ,
        lb.equipo, SUM(lbc.monto_final_comprometido_c) as suma , count(lb.assigned_user_id) as conteo
        from lev_backlog lb 
        LEFT join lev_backlog_cstm lbc on lb.id = lbc.id_c
        INNER JOIN  users u ON lb.assigned_user_id=u.id AND u.deleted=0
        LEFT JOIN users_cstm uc ON u.id = uc.id_c
        where -- uc.posicion_operativa_c = '^3^' 
         lb.assigned_user_id in ({$idUsuario}) 
        or lb.created_by in ({$idUsuario})  
        -- AND lb.equipo in ({$equipos})  and 
        AND lbc.estatus_operacion_c = '2' group by lb.equipo, lbc.etapa_solicitud_c ,  lbc.etapa_c  , lb.progreso ";
        //$GLOBALS['log']->fatal('queryAgrupado', $queryAgrupado);
        $result = $GLOBALS['db']->query($queryAgrupado);
       
        $queryTotal = "SELECT lb.equipo, SUM(lbc.monto_final_comprometido_c) as suma , count(lb.assigned_user_id) as conteo
        from lev_backlog lb 
        LEFT join lev_backlog_cstm lbc on lb.id = lbc.id_c
        INNER JOIN  users u ON lb.assigned_user_id=u.id AND u.deleted=0
        LEFT JOIN users_cstm uc ON u.id = uc.id_c
        where -- uc.posicion_operativa_c = '^3^' 
        lb.assigned_user_id in ({$idUsuario}) 
        -- AND lb.equipo in ({$equipos}) 
        AND lbc.estatus_operacion_c = '2'group by lb.equipo ";
        //$GLOBALS['log']->fatal('queryTotal', $queryTotal);
        $result2 = $GLOBALS['db']->query($queryTotal);
        
        //$GLOBALS['log']->fatal('equipos', $equipos);
        $equipos = str_replace("'","",$equipos);
        $tm = explode(",", $equipos);
        
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in['records'][] = array(
                'equipo' => $row['equipo'], 'filtro' => $row['filtro'], 'etapa_solicitud_c' => $row['etapa_solicitud_c'],'etapa'=>$row['etapa'],
                'solicitud'=>$row['solicitud'], 'suma' => $row['suma'], 'conteo' => $row['conteo']
            );
        }
        while ($row = $GLOBALS['db']->fetchByAssoc($result2)) {
            $records_in1['records'][] = array(
                'equipo' => $row['equipo'],'montoTotal' => $row['suma'], 'conteoTotal' => $row['conteo']
            );
        }

        $d0 = $this->groupArray($records_in['records'],'equipo', 'equipo');
        //$d1 = $this->groupArray($records_in1['records'],'equipo', 'equipo');
        //$GLOBALS['log']->fatal('records_in', $d0);
        //$GLOBALS['log']->fatal('records_in', $records_in1);

        $dataFinal = array();
        $j=0;
        foreach($d0 as $val){
            $item=null; 
            //$GLOBALS['log']->fatal('fl', $val);
            $nameteam = $val['equipo'];
            $dataaux = $val[$nameteam];
            $item['equipo'] = $val['equipo'];
            
            foreach ($dataaux as $key){
                if($key['filtro'] == "En proceso"){
                    if($key['etapa'] == '3'){ $item['prospecto'] =  $key['suma'] ;}
                    if($key['etapa'] == '4'){ $item['credito'] =  $key['suma'];   }
                    if($key['etapa'] == '2'){ $item['rechazada'] =  $key['suma']; }
                    
                }
                if($key['filtro'] == "Autorizado"){
                    if($key['solicitud'] == '2'){ $item['sinsc'] = $key['suma']; }
                    if($key['solicitud'] == '1'){ $item['consc'] = $key['suma'] ; }
                }
                $item['total'] = floatval($item['sinsc']) + floatval($item['consc']); 
            }
            foreach ($records_in1['records'] as $totals){
                if($totals['equipo'] == $nameteam){
                    $item['montoTotal'] =  $totals['montoTotal'] ;
                    $item['conteoTotal'] =  $totals['conteoTotal'];
                }
            }
            $return[$j]=$item;
            $j++;
            //dato1.total = parseFloat(dato1.sinsc) + parseFloat(dato1.consc); 
            //$busca = array_search($value[$groupkey], $groupcriteria); 
        }

        //$GLOBALS['log']->fatal('records_in2', $return);

        /*$records_exp = array_merge(
            array('Datos' => $d0),
            array('Totales' => $records_in1)
        );*/
        //$GLOBALS['log']->fatal('records_in', $records_in);
        return $return;
    }

    public function getTotalesAsesor($idUsuario, $equipos){
        $queryAgrupado = "SELECT lb.equipo,  IF(lbc.etapa_c = '1', 'Autorizado' ,  'En proceso' ) as filtro, lbc.etapa_solicitud_c ,  lbc.etapa_c as etapa , lb.progreso as solicitud ,
        SUM(lbc.monto_final_comprometido_c) as suma , count(lb.assigned_user_id) as conteo
        from lev_backlog lb 
        LEFT join lev_backlog_cstm lbc on lb.id = lbc.id_c
        INNER JOIN  users u ON lb.assigned_user_id=u.id AND u.deleted=0
        LEFT JOIN users_cstm uc ON u.id = uc.id_c
        where -- uc.posicion_operativa_c = '^3^' 
            lb.assigned_user_id in ({$idUsuario}) AND 
        -- AND lb.equipo in ({$equipos})  and 
        lbc.estatus_operacion_c = '2' group by  lb.equipo, lbc.etapa_solicitud_c ,  lbc.etapa_c  , lb.progreso ";
        //$GLOBALS['log']->fatal('queryAgrupado', $queryAgrupado);
        $result = $GLOBALS['db']->query($queryAgrupado);
       
        $queryTotal = "SELECT lb.equipo,  SUM(lbc.monto_final_comprometido_c) as suma , count(lb.assigned_user_id) as conteo
        from lev_backlog lb 
        LEFT join lev_backlog_cstm lbc on lb.id = lbc.id_c
        INNER JOIN  users u ON lb.assigned_user_id=u.id AND u.deleted=0
        LEFT JOIN users_cstm uc ON u.id = uc.id_c
        where -- uc.posicion_operativa_c = '^3^' 
         lb.assigned_user_id in ({$idUsuario}) AND
        -- AND lb.equipo in ({$equipos}) and 
        lbc.estatus_operacion_c = '2' group by lb.equipo";
        //$GLOBALS['log']->fatal('queryTotal', $queryTotal);
        $result2 = $GLOBALS['db']->query($queryTotal);
        
        //$GLOBALS['log']->fatal('result', $result);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in['records'][] = array(
                'equipo' => $row['equipo'],'filtro' => $row['filtro'], 'etapa_solicitud_c' => $row['etapa_solicitud_c'],'etapa'=>$row['etapa'],
                'solicitud'=>$row['solicitud'], 'suma' => $row['suma'], 'conteo' => $row['conteo']
            );
        }
        while ($row = $GLOBALS['db']->fetchByAssoc($result2)) {
            $records_in1['records'][] = array(
                'equipo' => $row['equipo'],'montoTotal' => $row['suma'], 'conteoTotal' => $row['conteo']
            );
        }
        //$GLOBALS['log']->fatal('records_in', $records_in);
        //$GLOBALS['log']->fatal('records_in1', $records_in1);
        $d0 = $this->groupArray($records_in['records'],'equipo', 'equipo');
        //$GLOBALS['log']->fatal('d0', $d0);

        $dataFinal = array();
        $j=0;
        foreach($d0 as $val){
            $item=null; 
            //$GLOBALS['log']->fatal('fl', $val);
            $nameteam = $val['equipo'];
            $dataaux = $val[$nameteam];
            $item['equipo'] = $val['equipo'];

            //$GLOBALS['log']->fatal('dataaux', $dataaux);
            foreach ($dataaux as $key){
                if($key['filtro'] == "En proceso"){
                    if($key['etapa'] == '3'){ $item['prospecto'] =  $key['suma'] ;}
                    if($key['etapa'] == '4'){ $item['credito'] =  $key['suma'];   }
                    if($key['etapa'] == '2'){ $item['rechazada'] =  $key['suma']; }
                    
                }
                if($key['filtro'] == "Autorizado"){
                    if($key['solicitud'] == '2'){ $item['sinsc'] = $key['suma']; }
                    if($key['solicitud'] == '1'){ $item['consc'] = $key['suma'] ; }
                }
                $item['total'] = floatval($item['sinsc']) + floatval($item['consc']); 
            }
            foreach ($records_in1['records'] as $totals){
                if($totals['equipo'] == $nameteam){
                    $item['montoTotal'] =  $totals['montoTotal'] ;
                    $item['conteoTotal'] =  $totals['conteoTotal'];
                }
            }
            $return[$j]=$item;
            $j++;
            //dato1.total = parseFloat(dato1.sinsc) + parseFloat(dato1.consc); 
            //$busca = array_search($value[$groupkey], $groupcriteria); 
        }
        //$GLOBALS['log']->fatal('records_in2', $return);
        /*$records_exp = array_merge(
            array('Datos' => $records_in),
            array('Totales' => $records_in1)
        );*/
        //$GLOBALS['log']->fatal('records_in', $records_in);
        return $return;
    }

    public function getTotalesQuery(){
       
        $sugarQuery = new SugarQuery();
        $sugarQuery->select(array('equipo','monto_final_comprometido_c'));
        $sugarQuery->from(BeanFactory::newBean('lev_Backlog'));
        $sugarQuery->where()->equals('estatus_operacion_c', '2');
        $sugarQuery->select()->setCountQuery();
        $sugarQuery->groupByRaw('lev_Backlog.equipo');
        $result = $sugarQuery->execute();
        $d0 = $this->groupArray($result,'equipo', 'equipo');
        //$GLOBALS['log']->fatal('result', $d0);
        $dataFinal = array();
        $x= 0;
        
        foreach($d0 as $val){
            $item=null;
            $montoTotal= 0.0;
            $conteoTotal=0;
            //$GLOBALS['log']->fatal('fl', $val);
            $nameteam = $val['equipo'];
            $dataaux = $val[$nameteam];
            $item['equipo'] = $val['equipo'];
            //$GLOBALS['log']->fatal('item', $item);
            foreach ($dataaux as $key){
                $montoTotal += floatval($key['monto_final_comprometido_c']);
                $conteoTotal += intval($key['record_count']);
            }
            $item['montoTotal'] = $montoTotal;
            $item['conteoTotal'] = $conteoTotal;
            $return[$x]=$item;
            $x++;
        }
        //$GLOBALS['log']->fatal('totales', $return);

        $sugarQuery = new SugarQuery();
        $sugarQuery->select(array('equipo','etapa_solicitud_c','etapa_c','progreso','monto_final_comprometido_c'));
        $sugarQuery->from(BeanFactory::newBean('lev_Backlog'));
        $sugarQuery->where()->equals('estatus_operacion_c', '2');
        $sugarQuery->select()->setCountQuery();
        $sugarQuery->groupByRaw('lev_Backlog.equipo','lev_Backlog.etapa_solicitud_c');
        $result = $sugarQuery->execute();
        //$GLOBALS['log']->fatal('result', $result);

        $d0 = $this->groupArray($result,'equipo', 'equipo');
        //$GLOBALS['log']->fatal('resultd0', $d0);
        
        $j=0;
        $aux = null;
        foreach($d0 as $val){
            $newitem=null; 
            //$GLOBALS['log']->fatal('fl', $val);
            $nameteam = $val['equipo'];
            $dataaux = $val[$nameteam];
            $newitem['equipo'] = $val['equipo'];
            //$GLOBALS['log']->fatal('item', $item);
            $prospecto=0.0;
            $credito=0.0;
            $rechazada=0.0;
            $sinsc=0.0;
            $consc=0.0;
    
            foreach ($dataaux as $key){
                if($key['etapa_c'] == '1'){
                    if($key['progreso'] == '2'){ $sinsc += $key['monto_final_comprometido_c']; }
                    if($key['progreso'] == '1'){ $consc += $key['monto_final_comprometido_c'] ; }
                }else{
                    if($key['etapa_c'] == '3'){ $prospecto += $key['monto_final_comprometido_c'] ;}
                    if($key['etapa_c'] == '4'){ $credito += $key['monto_final_comprometido_c'];   }
                    if($key['etapa_c'] == '2'){ $rechazada += $key['monto_final_comprometido_c']; }
                }
            }
            $newitem['total'] = $sinsc + $consc; 
            $newitem['prospecto'] =  $prospecto;
            $newitem['credito'] =  $credito; 
            $newitem['rechazada'] =  $rechazada; 
            $newitem['sinsc'] = $sinsc; 
            $newitem['consc'] = $consc; 
    
            $return1[$j]=$newitem;
            $j++;
            //dato1.total = parseFloat(dato1.sinsc) + parseFloat(dato1.consc); 
            //$busca = array_search($value[$groupkey], $groupcriteria); 
        }
        //$GLOBALS['log']->fatal('d00', $return1);
        $y=0;
        foreach($return1 as $value1){
            $itemf=null;
            foreach($return as $value){
                if($value['equipo'] == $value1['equipo']){
                    $itemf['equipo'] = $value1['equipo'];
                    $itemf['total'] = $value1['total'];
                    $itemf['prospecto'] = $value1['prospecto'];
                    $itemf['credito'] = $value1['credito'];
                    $itemf['rechazada'] = $value1['rechazada'];
                    $itemf['sinsc'] = $value1['sinsc'];
                    $itemf['consc'] = $value1['consc'];
                    $itemf['montoTotal'] = $value['montoTotal'];
                    $itemf['conteoTotal'] = $value['conteoTotal'];
                    $return2[$y]=$itemf;
                    $y++;
                }
            }
        }
        //$GLOBALS['log']->fatal('final', $return2);
        return $return2;
    }

    public function groupArray($array,$groupkey,$newgroup){
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
                  //$GLOBALS['log']->fatal('grouparray - '.$value[$groupkey]);
                  if ($busca === false){
                    $groupcriteria[]=$value[$groupkey];
                    $return[]=array($groupkey=>$value[$groupkey],$value[$groupkey]=>array());
                    //$return[]=array($groupkey=>$value[$groupkey],$nt=>array());
                    $busca=count($return)-1;
                }
     		    $return[$busca][$value[$groupkey]][]=$item;
                //$return[$busca][$nt][]=$item;
     	    }
     	    return $return;
        }else
     	    return array();
    }
    
}
