<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetResumenProspecto extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETResumeProspectoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetResumenProspecto','?'),
                'pathVars' => array('module', 'tdirector'),
                'method' => 'getResumenDatos',
                'shortHelp' => 'Obtiene toda la información de lead management en resumen para Directivos ',
            ),
        );
    }

    public function getResumenDatos($api, $args){

        try {
            global $current_user;
            $id_user = $current_user->id;
            $posicion_operativa = $current_user->posicion_operativa_c;
            //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
            $tdirector = $args['tdirector'];
            $GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
            $GLOBALS['log']->fatal('id_user', $id_user,' - ',$current_user->user_name);
            $GLOBALS['log']->fatal('tdirector', $tdirector);

            $records = [];
            $records_exp = [];
            $records_int = [];
            $records_cnt = [];
            $records_led = [];

            $equip = [];
            $reg = [];

            list ($usuarios, $equip, $reg) = $this->getusuarios($id_user, $tdirector , $posicion_operativa);
            $GLOBALS['log']->fatal('usuarios inicial', $usuarios);
            $GLOBALS['log']->fatal('equipo inicial', $equip);
            $GLOBALS['log']->fatal('region inicial', $reg);
            $records_exp = $this->valores_expediente($tdirector,$usuarios);
            $records_int = $this->valores_interesados($tdirector,$usuarios);
            $records_cnt = $this->valores_contactados($tdirector,$usuarios);
            $records_led = $this->valores_leads($tdirector,$usuarios);

            //$GLOBALS['log']->fatal('records_exp', $records_exp);
            //$GLOBALS['log']->fatal('records_int', $records_int);
            //$GLOBALS['log']->fatal('records_cnt', $records_cnt);
            //$GLOBALS['log']->fatal('records_led', $records_led);

            if($tdirector == "1"){
                $dataexp = $this->groupComplete($records_exp['records']);
                $dataint = $this->groupComplete($records_int['records']);
                $datacnt = $this->groupComplete($records_cnt['records']);
                $dataled = $this->groupComplete($records_led['records']);
            }

            if($tdirector == "2"){
                $dataexp = $this->groupRegion($records_exp['records']);
                $dataint = $this->groupRegion($records_int['records']);
                $datacnt = $this->groupRegion($records_cnt['records']);
                $dataled = $this->groupRegion($records_led['records']);
            }
            $records_exp = array('expediente' => $dataexp);
            $records_int = array('interesado' => $dataint);
            $records_cnt = array('contactado' => $datacnt);
            $records_led = array('lead' => $dataled);

            //$GLOBALS['log']->fatal('dataexp', $dataexp);
            //$GLOBALS['log']->fatal('records_int', $records_int);
            //$GLOBALS['log']->fatal('records_cnt', $records_cnt);
            //$GLOBALS['log']->fatal('records_led', $records_led);
            //$records = array_merge($equipo, $region);
            $records = array_merge($equip, $reg,$records_exp, $records_int, $records_cnt , $records_led);
            //$GLOBALS['log']->fatal('records1', $records);
            //$GLOBALS['log']->fatal('records1-json', json_encode($records));
            return $records;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    function groupRegion($array){
        //$GLOBALS['log']->fatal('agrupador general',$array);
        $aux = $array;

        $aux = $this->groupArray($aux,'region', 'equipos');
        $aux2 = [];
        $aux3 = [];
        $aux4 = [];
        $aux5 = [];
        foreach ($aux as $key => $value) {
            //$GLOBALS['log']->fatal('value-1', $value['equipos']);
            $aux2 = $this->groupArray($value['equipos'],'equipo', 'datos');
            //$GLOBALS['log']->fatal('aux2', $aux2);
            /*foreach ($aux2 as $key1 => $value1) {
                //$GLOBALS['log']->fatal('value-2', $value1['datos']);
                $aux3 = $this->groupArray($value1['datos'],'inactivo', 'actinct');
                //$GLOBALS['log']->fatal('aux3', $aux3);
                $aux2[$key1]['datos'] = $aux3;
            }*/
            $aux[$key]['equipos'] = $aux2;
        }
        //$GLOBALS['log']->fatal('data1', $aux);
        return $aux;
    }

    function groupComplete($array){
        //$GLOBALS['log']->fatal('agrupador general',$array);
        $aux = $array;

        $aux = $this->groupArray($aux,'equipo', 'usuarios');
        $aux2 = [];
        $aux3 = [];
        $aux4 = [];
        $aux5 = [];
        foreach ($aux as $key => $value) {
            //$GLOBALS['log']->fatal('value-1', $value['usuarios']);
            $aux2 = $this->groupArray($value['usuarios'],'usuario', 'datos');
            //$GLOBALS['log']->fatal('aux2', $aux2);
            //foreach ($aux2 as $key1 => $value1) {
                //$GLOBALS['log']->fatal('value-2', $value1['datos']);
                //$aux3 = $this->groupArray($value1['datos'],'inactivo', 'actinct');
                //$GLOBALS['log']->fatal('aux3', $aux3);
                //$aux2[$key1]['datos'] = $aux3;
            //}
            $aux[$key]['usuarios'] = $aux2;
        }
        //$GLOBALS['log']->fatal('data1', $aux);
        return $aux;
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

    public function getusuarios($id_user,$tdirector, $posicion_operativa){
        $usuariosin ="";
        $equipo = [];
        $region = [];

        $sqlteams = "SELECT REPLACE(uc.equipos_c,'^','\'') as equipos from users_cstm uc
        where id_c = '{$id_user}'";
        $tteams ="";

        $result = $GLOBALS['db']->query($sqlteams);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $tteams = $row['equipos'];
        }
        //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
        //$GLOBALS['log']->fatal('tteams', $tteams);
        $pos = strrpos($posicion_operativa, "1");
        //$GLOBALS['log']->fatal('pos', $pos);
        //$GLOBALS['log']->fatal('tdirector', $tdirector);
        if ($pos != '' && $tdirector == 1) { //valida usuario director equipo
            $queryusuarios = "SELECT id, user_name, puestousuario_c,equipo_c, region_c from users
            join users_cstm on users.id = users_cstm.id_c where equipo_c in ({$tteams})
             and posicion_operativa_c like '%3%' --  puestousuario_c in ('5') -- ('1','2','3','4','5','6','20','33','44','55')
            order by equipo_c";
            //$GLOBALS['log']->fatal('queryusuarios', $queryusuarios);
            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $usuariosin = $usuariosin."'". $row['id'] . "',";
                array_push($equipo,$row['equipo_c']);
                array_push($region,$row['region_c']);
            }
            $usuariosin = substr($usuariosin,0,-1);
        }

        $pos = strrpos($posicion_operativa, "2");
        //$GLOBALS['log']->fatal('pos', $pos);
        if ($pos  != ''  && $tdirector == 2) { //valida usuario director regional
            $usuariosin ="";
            $equipos_director = [];
            $equipomu = "SELECT REPLACE(uc.equipos_c,'^','\'') as equipos2
            from users_cstm uc where id_c in (
                select id -- , user_name, puestousuario_c , posicion_operativa_c , region_c , equipo_c, reports_to_id
                from users join users_cstm on users.id = users_cstm.id_c where
                equipo_c in ($tteams)  and  posicion_operativa_c like '%1%' )";
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

            $queryusuarios = "SELECT id, user_name, puestousuario_c,equipo_c,region_c from users
            join users_cstm on users.id = users_cstm.id_c where equipo_c in
            ( {$salidaequipos} ) and posicion_operativa_c like '%3%' --  puestousuario_c in ('5') -- ('1','2','3','4','5','6','20','33','44','55')
            order by equipo_c";
            //$GLOBALS['log']->fatal('queryusuarios', $queryusuarios);
            $result = $GLOBALS['db']->query($queryusuarios);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $usuariosin = $usuariosin. "'".$row['id'] . "',";
                array_push($equipo,$row['equipo_c']);
                array_push($region,$row['region_c']);
            }
            $usuariosin = substr($usuariosin,0,-1);
            //$GLOBALS['log']->fatal('usuarios', $usuarios);
        }
        $equipo = array_unique($equipo);
        $equipo = array('equipo' => $equipo);
        $region = array_unique($region);
        $region = array('region' => $region);

        return array($usuariosin, $equipo, $region);
    }

    public function valores_expediente($tdirector,$usuarios){
        //$GLOBALS['log']->fatal('entro expediente');
        //$GLOBALS['log']->fatal('tdirec'.$tdirector);
        //$GLOBALS['log']->fatal('usuarios',$usuarios);
        $records_in = [];
        $query = "SELECT ";
        if($tdirector == "1"){
            $query = $query . "usuario.usuario, ";
        }
        if($tdirector == "2"){
            $query = $query . "usuario.region_c, ";
        }

        $query = $query . "usuario.equipo_c ,count(cuentas.nombreCuenta) NumCuentas, producto.EstatusProducto
        -- , tipoCuenta,subtipoCuenta , val_dias_20,val_dias_10 , fecha_asignacion,daypas, tipo_producto, oppEtapa
        ,CASE WHEN producto.EstatusProducto = 2 THEN 1
        WHEN producto.EstatusProducto = 3 THEN 1
        ELSE 0
        END AS inactivo
        ,CASE WHEN solicitudes.val_dias_20 = 20 and solicitudes.monto > 10000000 THEN 0
        WHEN solicitudes.val_dias_20 = -20 and solicitudes.monto > 10000000 THEN 1
        WHEN solicitudes.val_dias_10 = 10 and (solicitudes.monto <= 10000000 ) THEN 0
        WHEN solicitudes.val_dias_10 = -10 and (solicitudes.monto <= 10000000) THEN 1
        END AS semaforo
        FROM
        (	SELECT a.id, a.name nombreCuenta, ac.user_id_c, ac.tipo_registro_c
            FROM accounts a
            INNER JOIN accounts_cstm ac on ac.id_c = a.id
            WHERE ac.user_id_c in ({$usuarios}) and a.deleted = 0
           -- group by ac.user_id_c
        ) AS CUENTAS INNER JOIN
        (	SELECT aup.accounts_uni_productos_1accounts_ida , aup.accounts_uni_productos_1uni_productos_idb ,
            up.tipo_cuenta tipoCuenta, up.subtipo_cuenta subtipoCuenta,up.name nameProd, up.tipo_producto , upc.status_management_c EstatusProducto
            FROM uni_productos up
            INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
            INNER JOIN accounts_uni_productos_1_c aup on up.id = aup.accounts_uni_productos_1uni_productos_idb
            WHERE -- up.tipo_cuenta in ('2') or  up.subtipo_cuenta in ('1','2','7','8','10')
            up.tipo_cuenta = '2' and  up.subtipo_cuenta in ('8','10')
            and tipo_producto = '1'and  up.deleted = 0
            group by  aup.accounts_uni_productos_1accounts_ida , aup.accounts_uni_productos_1uni_productos_idb
        ) AS PRODUCTO on CUENTAS.id = PRODUCTO.producto.accounts_uni_productos_1accounts_ida
        INNER JOIN (select id, user_name,concat(first_name, ' ' ,last_name) usuario,equipo_c, region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
        ON cuentas.user_id_c = usuario.id
        LEFT JOIN (SELECT app.account_id acc, opp.date_modified, TIMESTAMPDIFF(DAY, opp.date_modified, now()) as daypas,
            opp.id as idOpp, opp.name as oppNombre, oppcstm.tipo_producto_c, opp.assigned_user_id oppassigned, oppcstm.tct_etapa_ddw_c, oppcstm.estatus_c,
            oppcstm.tct_estapa_subetapa_txf_c as oppEtapa, DATE_FORMAT( opp.date_modified, '%Y-%m-%d ') as fecha_asignacion,
            opp.amount as monto,
            DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ')  as veinte,
            DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ')  as diez,
            CASE WHEN opp.date_modified <  DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ') THEN '20'
            WHEN opp.date_modified >  DATE_FORMAT(DATE_SUB(now(), INTERVAL 20 DAY), '%Y-%m-%d ') THEN '-20'
            END AS val_dias_20,
            CASE WHEN opp.date_modified < DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ') THEN '10'
            WHEN opp.date_modified > DATE_FORMAT(DATE_SUB(now(), INTERVAL 10 DAY), '%Y-%m-%d ') THEN '-10'
            END AS val_dias_10
            FROM accounts_opportunities app
            INNER JOIN opportunities opp on opp.id = app.opportunity_id
            INNER JOIN opportunities_cstm oppcstm on oppcstm.id_c = opp.id
            INNER JOIN (
                SELECT app.account_id uac, opp.id oppid, opp.name, max(opp.date_modified) as dayb , min(TIMESTAMPDIFF(DAY, opp.date_modified, now())) as daypas
                FROM accounts_opportunities app
                INNER JOIN opportunities opp on opp.id = app.opportunity_id
				INNER JOIN opportunities_cstm opc on opp.id = opc.id_c
                where  opp.assigned_user_id in ({$usuarios})
                and opc.tipo_producto_c = '1'
            group by app.account_id order by app.account_id
            ) AS ultimos on ultimos.uac = app.account_id and ultimos.dayb = opp.date_modified
            group by app.account_id
            order by daypas
            ) as solicitudes
        ON cuentas.id = solicitudes.acc";

        if($tdirector == "1"){
            $query = $query ." group by equipo_c, user_name,  inactivo ,EstatusProducto , semaforo
            order by user_name, EstatusProducto , semaforo";
        }
        if($tdirector == "2"){
            $query = $query ." group by region_c ,equipo_c, inactivo ,EstatusProducto , semaforo
            order by equipo_c, EstatusProducto, semaforo";
        }
        //$GLOBALS['log']->fatal('query_expediente',$query);
        if($tdirector == "1"){
            $result = $GLOBALS['db']->query($query);
            //$GLOBALS['log']->fatal('result',$result);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'usuario' => $row['usuario'], 'equipo' => $row['equipo_c'],
                     'conteo' => $row['NumCuentas'],'EstatusProducto' => $row['EstatusProducto'],
                     'inactivo' => $row['inactivo'] , 'semaforo' => $row['semaforo']
                );
            }
        }

        if($tdirector == "2"){
            $result = $GLOBALS['db']->query($query);
            //$GLOBALS['log']->fatal('result',$result);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'equipo' => $row['equipo_c'], 'region' => $row['region_c'], 'conteo' => $row['NumCuentas'],
                    'EstatusProducto' => $row['EstatusProducto'],
                    'inactivo' => $row['inactivo'] ,'semaforo' => $row['semaforo']
                );
            }
        }
        return $records_in;
    }

    public function valores_interesados($tdirector,$usuarios){
        //$GLOBALS['log']->fatal('entro expediente');
        //$GLOBALS['log']->fatal('tdirec'.$tdirector);
        //$GLOBALS['log']->fatal('usuarios',$usuarios);
        $records_in = [];
        $query = "SELECT ";
        if($tdirector == "1"){
            $query = $query . "usuario.usuario, ";
        }
        if($tdirector == "2"){
            $query = $query . "usuario.region_c, ";
        }
        $query = $query . "usuario.equipo_c , count(cuentas.cuentas) NumCuentas -- , producto.tipo_cuenta, producto.subtipo_cuenta
        , producto.EstatusProducto -- solicitudes.daypas , solicitudes.date_modified,
        ,CASE WHEN (producto.EstatusProducto = '2') THEN 1
        WHEN (producto.EstatusProducto = '3') THEN 1
        ELSE 0
        END AS inactivo
        ,CASE WHEN (solicitudes.daypas < 5) THEN 1
        WHEN (solicitudes.daypas > 5) THEN 0
        END AS semaforo
         FROM
        (	SELECT a.id, a.name cuentas, ac.user_id_c, ac.tipo_registro_c
            FROM accounts a
            INNER JOIN accounts_cstm ac on ac.id_c = a.id
            WHERE ac.user_id_c in ({$usuarios}) and a.deleted = 0
           -- group by ac.user_id_c
        ) AS CUENTAS ,
        (	SELECT aup.accounts_uni_productos_1accounts_ida , aup.accounts_uni_productos_1uni_productos_idb ,
            up.tipo_cuenta, up.subtipo_cuenta,up.name nameProd, up.tipo_producto , upc.status_management_c EstatusProducto
            FROM uni_productos up
            INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
            INNER JOIN accounts_uni_productos_1_c aup on up.id = aup.accounts_uni_productos_1uni_productos_idb
            WHERE -- up.tipo_cuenta in ('2') or  up.subtipo_cuenta in ('1','2','7','8','10')
            up.tipo_cuenta = '2' and  up.subtipo_cuenta in ('7')
                -- and upc.status_management_c = '{$statusProduct}'
            and tipo_producto = '1'and  up.deleted = 0
            group by  aup.accounts_uni_productos_1accounts_ida , aup.accounts_uni_productos_1uni_productos_idb
        ) AS PRODUCTO,
        (select id, user_name,concat(first_name, ' ' ,last_name) usuario , equipo_c , region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario,
            (SELECT app.account_id acc, opp.date_modified, TIMESTAMPDIFF(DAY, opp.date_modified, now()) as daypas,
                opp.id as idOpp, opp.name as oppNombre, oppcstm.tipo_producto_c, opp.assigned_user_id oppassigned,
                oppcstm.tct_etapa_ddw_c, oppcstm.estatus_c,	oppcstm.tct_estapa_subetapa_txf_c, opp.amount as monto
                FROM accounts_opportunities app
                INNER JOIN opportunities opp on opp.id = app.opportunity_id
                INNER JOIN opportunities_cstm oppcstm on oppcstm.id_c = opp.id
                INNER JOIN (
                    SELECT app.account_id uac, opp.id oppid, opp.name, max(opp.date_modified) as dayb , min(TIMESTAMPDIFF(DAY, opp.date_modified, now())) as daypas
                    FROM accounts_opportunities app INNER JOIN opportunities opp on opp.id = app.opportunity_id
                    where  opp.assigned_user_id in ({$usuarios})
                group by app.account_id order by app.account_id
                ) AS ultimos on ultimos.uac = app.account_id and ultimos.dayb = opp.date_modified
                WHERE
                oppcstm.tipo_producto_c = '1'
                and opp.assigned_user_id in ({$usuarios})
                group by app.account_id
                order by app.account_id
            ) as solicitudes
        where cuentas.id = producto.accounts_uni_productos_1accounts_ida
        and cuentas.user_id_c = usuario.id
        and cuentas.id = solicitudes.acc";

        if($tdirector == "1"){
            $query = $query ." group by equipo_c , user_name, inactivo ,EstatusProducto , semaforo
            order by user_name, EstatusProducto , semaforo";
        }
        if($tdirector == "2"){
            $query = $query ." group by region_c , equipo_c, inactivo ,EstatusProducto , semaforo
            order by equipo_c, EstatusProducto , semaforo";
        }

        //$GLOBALS['log']->fatal('query_interesados',$query);
        if($tdirector == "1"){
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'usuario' => $row['usuario'], 'equipo' => $row['equipo_c'],
                    'conteo' => $row['NumCuentas'], 'EstatusProducto' => $row['EstatusProducto'],
                    'inactivo' => $row['inactivo'],'semaforo' => $row['semaforo']
                );
            }
        }

        if($tdirector == "2"){
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'equipo' => $row['equipo_c'], 'region' => $row['region_c'],
                    'conteo' => $row['NumCuentas'],'EstatusProducto' => $row['EstatusProducto'],
                    'inactivo' => $row['inactivo'], 'semaforo' => $row['semaforo']
                );
            }
        }
        return $records_in;
    }

    public function valores_contactados($tdirector,$usuarios){
        //$GLOBALS['log']->fatal('entro expediente');
        //$GLOBALS['log']->fatal('tdirec'.$tdirector);
        //$GLOBALS['log']->fatal('usuarios',$usuarios);
        $records_in = [];
        $query = "SELECT ";
        if($tdirector == "1"){
            $query = $query . "usuario.usuario, ";
        }
        if($tdirector == "2"){
            $query = $query . "usuario.region_c, ";
        }
        $query = $query . " usuario.equipo_c ,count(cuentas.cuentas) NumCuentas,
        -- producto.tipo_cuenta, producto.subtipo_cuenta ,
        producto.EstatusProducto
       ,CASE WHEN producto.EstatusProducto = '2' THEN 1
           WHEN producto.EstatusProducto = '3' THEN 1
           ELSE 0
           END AS inactivo
       ,CASE WHEN producto.daypas < 5 THEN 1
           WHEN producto.daypas > 5 THEN 0
           END AS semaforo
       FROM
       (	SELECT a.id, a.name cuentas, ac.user_id_c, ac.tipo_registro_c
           FROM accounts a
           INNER JOIN accounts_cstm ac on ac.id_c = a.id
           WHERE ac.user_id_c in ({$usuarios}) and a.deleted = 0
          -- group by ac.user_id_c
       ) AS CUENTAS ,
       (	SELECT aup.accounts_uni_productos_1accounts_ida , aup.accounts_uni_productos_1uni_productos_idb ,up.tipo_cuenta
           , up.subtipo_cuenta,up.name nameProd, up.tipo_producto , upc.status_management_c EstatusProducto,upc.fecha_asignacion_c
           ,TIMESTAMPDIFF(DAY, upc.fecha_asignacion_c, now()) as daypas --  now()
           FROM uni_productos up
           INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
           INNER JOIN accounts_uni_productos_1_c aup on up.id = aup.accounts_uni_productos_1uni_productos_idb
           WHERE -- up.tipo_cuenta in ('2') or  up.subtipo_cuenta in ('1','2','7','8','10')
            up.tipo_cuenta = '2' and up.subtipo_cuenta in ('1','2')
           and tipo_producto = '1'and  up.deleted = 0
           group by  aup.accounts_uni_productos_1accounts_ida , aup.accounts_uni_productos_1uni_productos_idb
       ) AS PRODUCTO,
       (select id, user_name,concat(first_name, ' ' ,last_name) usuario ,equipo_c, region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
       where cuentas.id = producto.accounts_uni_productos_1accounts_ida
       and cuentas.user_id_c = usuario.id";

        if($tdirector == "1"){
            $query = $query ." group by equipo_c,user_name, inactivo ,EstatusProducto , semaforo
            order by user_name, EstatusProducto, semaforo";
        }
        if($tdirector == "2"){
            $query = $query ." group by region_c , equipo_c,inactivo ,EstatusProducto , semaforo
            order by equipo_c, EstatusProducto, semaforo";
        }

        //$GLOBALS['log']->fatal('query_contactados',$query);
        if($tdirector == "1"){
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'usuario' => $row['usuario'], 'equipo' => $row['equipo_c'],
                    'conteo' => $row['NumCuentas'], 'EstatusProducto' => $row['EstatusProducto'],
                    'inactivo' => $row['inactivo'],'semaforo' => $row['semaforo']
                );
            }
        }

        if($tdirector == "2"){
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'equipo' => $row['equipo_c'],'region' => $row['region_c'], 'conteo' => $row['NumCuentas'],
                    'EstatusProducto' => $row['EstatusProducto'],
                    'inactivo' => $row['inactivo'],'semaforo' => $row['semaforo']
                );
            }
        }
        return $records_in;
    }

    public function valores_leads($tdirector,$usuarios){
        //$GLOBALS['log']->fatal('entro leads');
        //$GLOBALS['log']->fatal('tdirec'.$tdirector);
        //$GLOBALS['log']->fatal('usuarios',$usuarios);
        $records_in = [];

        $query = "SELECT ";
        if($tdirector == "1"){
            $query = $query . " usuario.usuario, ";
        }
        if($tdirector == "2"){
            $query = $query . "usuario.region_c, ";
        }
        $query = $query . " usuario.equipo_c , count(cuenta) NumLeads, estatus, semaforo, inactivo
        FROM
    	(SELECT idLead, assigned_user_id ,cuenta, fechaAsignacion, daypas, tipo, subtipo, estatus, max(semaforo) semaforo, inactivo
            FROM (
                SELECT DISTINCT l.id as idLead, l.assigned_user_id , lc.name_c as cuenta, la.date_created as fechaAsignacion,
                TIMESTAMPDIFF(DAY, la.date_created, now()) as daypas, lc.tipo_registro_c as tipo,
                lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
                CASE WHEN la.date_created < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
                WHEN la.date_created > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
                END AS semaforo,
                CASE WHEN lc.status_management_c = '2' THEN 1
				WHEN lc.status_management_c = '3' THEN 1
				ELSE 0
				END AS inactivo
                FROM leads l
                INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                inner join leads_audit la on la.parent_id = l.id
                where la.field_name='assigned_user_id'
                and la.after_value_string = l.assigned_user_id
                AND l.assigned_user_id in ({$usuarios})
                AND  lc.subtipo_registro_c in (1,2,3)
                -- AND (lc.status_management_c = '' or lc.status_management_c is null)
                AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
                UNION
                    SELECT DISTINCT l.id as idLead, l.assigned_user_id ,lc.name_c as cuenta, c.date_end as fechaAsignacion,
                    TIMESTAMPDIFF(DAY, c.date_end, now()) as daypas,lc.tipo_registro_c as tipo,
                    lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
                    CASE WHEN c.date_end < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
                    WHEN c.date_end > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
                    END AS semaforo,
                    CASE WHEN lc.status_management_c = '2' THEN 1
					WHEN lc.status_management_c = '3' THEN 1
					ELSE 0
                    END AS inactivo
                    FROM leads l
                    INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                    INNER JOIN calls_leads cl on cl.lead_id = lc.id_c
                    inner join calls c on c.id = cl.call_id AND c.deleted = 0
                    WHERE l.assigned_user_id in ({$usuarios})
                    AND lc.subtipo_registro_c in (1,2,3)
                    -- AND (lc.status_management_c = '{$estatusProduct}' or lc.status_management_c is null)
                    AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
                    UNION
                    SELECT DISTINCT l.id as idLead, l.assigned_user_id , lc.name_c as cuenta, m.date_end as fechaAsignacion,
                    TIMESTAMPDIFF(DAY, m.date_end, now()) as daypas, lc.tipo_registro_c as tipo,
                    lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
                    CASE WHEN m.date_end < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
                    WHEN m.date_end > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
                    END AS semaforo,
                    CASE WHEN lc.status_management_c = '2' THEN 1
					WHEN lc.status_management_c = '3' THEN 1
					ELSE 0
                    END AS inactivo
                    FROM leads l
                    INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
                    inner join meetings_leads ml on ml.lead_id = lc.id_c
                    inner join meetings m on m.id = ml.meeting_id AND m.deleted = 0
                    WHERE l.assigned_user_id in ({$usuarios})
                    AND lc.subtipo_registro_c in (1,2,3)
                    -- AND (lc.status_management_c = '{$estatusProduct}' or lc.status_management_c is null)
                    AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
                ) tablaLeads
	group by idLead, cuenta, tipo, subtipo, estatus
	) AS tablal
	, (select id, user_name,concat(first_name, ' ' ,last_name) usuario,equipo_c,region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
    where tablal.assigned_user_id = usuario.id ";

        if($tdirector == "1"){
            $query = $query ." group by usuario.equipo_c , usuario.usuario , estatus , inactivo , semaforo
            order by usuario.usuario, inactivo, semaforo";
        }
        if($tdirector == "2"){
            $query = $query ." group by usuario.region_c , usuario.equipo_c , estatus , inactivo, semaforo
            order by usuario.region_c , usuario.equipo_c , inactivo, semaforo";
        }
        //$GLOBALS['log']->fatal('query_lead',$query);

        if($tdirector == "1"){
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'usuario' => $row['usuario'],  'equipo' => $row['equipo_c'], 'conteo' => $row['NumLeads'],
                    'EstatusProducto' => $row['estatus'],'inactivo' => $row['inactivo'],
                    'semaforo' => $row['semaforo']
                );
            }
        }

        if($tdirector == "2"){
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array(
                    'equipo' => $row['equipo_c'], 'region' => $row['region_c'], 'conteo' => $row['NumLeads'],
                    'EstatusProducto' => $row['estatus'],'inactivo' => $row['inactivo'],
                    'semaforo' => $row['semaforo']
                );
            }
        }
        return $records_in;
    }
}
