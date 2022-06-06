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

            $GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
            $GLOBALS['log']->fatal('id_user', $id_user.' - '.$current_user->user_name);

            $records = [];
            $records_totales = [];

            $pos = strrpos($posicion_operativa, "3");
            $GLOBALS['log']->fatal('pos', $pos);
            if($pos != ""){
                $records = $this->getTotales( "'".$id_user."'" );
                $GLOBALS['log']->fatal('records', $records);
            }else{
                
                list ($usuarios, $equipo , $reg) = $this->getusuarios($id_user , $posicion_operativa);
                $GLOBALS['log']->fatal('usuarios', $usuarios);
                $GLOBALS['log']->fatal('equipo', $equipo);
                $GLOBALS['log']->fatal('reg', $reg);

                $records = $this->getTotales( $usuarios );
            }
            
            //$GLOBALS['log']->fatal('records2-json', json_encode($records));
            //$GLOBALS['log']->fatal('records2', $records);
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

        $sqlteams = "SELECT REPLACE(uc.equipos_c,'^','\'') AS equipos from users_cstm uc WHERE id_c = '{$id_user}'";
        $GLOBALS['log']->fatal('sqlteams', $sqlteams);

        $result = $GLOBALS['db']->query($sqlteams);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $tteams = $row['equipos'];
        }
        //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
        //$GLOBALS['log']->fatal('tteams', $tteams);
        
        $pos = strrpos($posicion_operativa, "1");
        if ($pos != "") { //valida usuario director equipo
            $queryusuarios = "SELECT u.id, u.user_name, uc.puestousuario_c, uc.equipo_c, uc.equipos_c, uc.region_c from users u
            join users_cstm uc on u.id = uc.id_c where uc.equipo_c in ({$tteams})
            and posicion_operativa_c like '%3%'  and users.status = 'Active'
            and u.status = 'Active' order by equipo_c";

            $GLOBALS['log']->fatal('queryusuarios-2-', $queryusuarios);
            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //array_push($usuario,$row['id']);
                $usuarios .= "'". $row['id'] . "',";
                array_push($equipo,$row['equipo_c']);
                array_push($region,$row['region_c']);
            }
        }
        
        $pos = strrpos($posicion_operativa, "2");
        $GLOBALS['log']->fatal('pos', $pos);

        if ($pos != "") { //valida usuario director regional
            $usuariosin ="";
            $equipos_director = [];
            $equipomu = "SELECT REPLACE(uc.equipos_c,'^','\'') as equipos2
            from users_cstm uc where id_c in (
                select id -- , user_name, puestousuario_c , posicion_operativa_c , region_c , equipo_c, reports_to_id
                from users join users_cstm on users.id = users_cstm.id_c where
                equipo_c in ($tteams)  and  posicion_operativa_c like '%1%' and users.status = 'Active' )";
            $GLOBALS['log']->fatal('equipomu', $equipomu);
            $result = $GLOBALS['db']->query($equipomu);
            //$GLOBALS['log']->fatal('result', $result);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                array_push($equipos_director,$row['equipos2']);
            }
            $GLOBALS['log']->fatal('equipos_director', $equipos_director);
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
            $GLOBALS['log']->fatal('queryusuarios', $queryusuarios);
            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //array_push($usuario,$row['id']);
                $usuarios .= "'".$row['id'] . "',";
                array_push($equipo,$row['equipo_c']);
                array_push($region,$row['region_c']);
            }
            $usuarios = substr($usuarios,0,-1);
        }
        
        //$usuario = array_unique($usuario);
        //$usuario = array('usuario' => $usuario);
        $equipo = array_unique($equipo);
        $equipo = array('equipo' => $equipo);
        $region = array_unique($region);
        $region = array('region' => $region);

        return array($usuarios, $equipo, $region);
    }
    
    public function getTotales($idUsuario){
        $queryAgrupado = "SELECT   IF(lbc.etapa_c = '1', 'Autorizado' ,  'En proceso' ) as filtro, lbc.etapa_solicitud_c ,  lbc.etapa_c as etapa , lb.progreso as solicitud ,
        SUM(lbc.monto_final_comprometido_c) as suma , count(lb.assigned_user_id) as conteo
        from lev_backlog lb inner join lev_backlog_cstm lbc on lb.id = lbc.id_c 
        where  lb.assigned_user_id in ({$idUsuario}) and 
        lbc.estatus_operacion_c = '2' group by  lbc.etapa_solicitud_c ,  lbc.etapa_c  , lb.progreso ,lb.assigned_user_id";
        $GLOBALS['log']->fatal('queryAgrupado', $queryAgrupado);
        $result = $GLOBALS['db']->query($queryAgrupado);
       
        $queryTotal = "SELECT  SUM(lbc.monto_final_comprometido_c) as suma , count(lb.assigned_user_id) as conteo
        from lev_backlog lb inner join lev_backlog_cstm lbc on lb.id = lbc.id_c 
        where  lb.assigned_user_id in ({$idUsuario}) and 
        lbc.estatus_operacion_c = '2' group by  lb.assigned_user_id";
        $GLOBALS['log']->fatal('queryTotal', $queryTotal);
        $result2 = $GLOBALS['db']->query($queryTotal);
        
        //$GLOBALS['log']->fatal('result', $result);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in['records'][] = array(
                'filtro' => $row['filtro'], 'etapa_solicitud_c' => $row['etapa_solicitud_c'],'etapa'=>$row['etapa'],
                'solicitud'=>$row['solicitud'], 'suma' => $row['suma'], 'conteo' => $row['conteo']
            );
        }
        while ($row = $GLOBALS['db']->fetchByAssoc($result2)) {
            $records_in1['records'][] = array(
                'montoTotal' => $row['suma'], 'conteoTotal' => $row['conteo']
            );
        }

        $records_exp = array_merge(
            array('Datos' => $records_in),
            array('Totales' => $records_in1)
        );
        //$GLOBALS['log']->fatal('records_in', $records_in);
        return $records_exp;
    }

}
