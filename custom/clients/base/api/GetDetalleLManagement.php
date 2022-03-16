<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetDetalleLManagement extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETResumeProspectoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetDetalleLManagement','?'),
                'pathVars' => array('module', 'tdirector'),
                'method' => 'getDetalleDatos',
                'shortHelp' => 'Obtiene toda la información de lead management en en detalle para Directivos ',
            ),
        );
    }

    public function getDetalleDatos($api, $args){

        try {
            global $current_user;
            $id_user = $current_user->id;
            $posicion_operativa = $current_user->posicion_operativa_c;
            $tdirector = $args['tdirector'];

            $GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
            $GLOBALS['log']->fatal('id_user', $id_user,' - ',$current_user->user_name);
            $GLOBALS['log']->fatal('tdirector', $tdirector);

            $records = [];
            $records_exp = [];
            $records_int = [];
            $records_cnt = [];
            $records_led = [];
            $detalle_exp_activo = [];
            $detalle_exp_aplazado = [];
            $detalle_int_activo = [];
            $detalle_int_aplazado = [];
            $detalle_cnt_activo = [];
            $detalle_cnt_aplazado = [];
            $equip = [];
            $reg = [];

            list ($usuarios, $equip, $reg) = $this->getusuarios($id_user, $tdirector , $posicion_operativa);
            $GLOBALS['log']->fatal('usuarios', $usuarios);
            $GLOBALS['log']->fatal('equipo', $equipo);
            $GLOBALS['log']->fatal('reg', $reg);
            $detalle_exp_activo     = $this->detalle_expediente($usuarios,'1');
            //$GLOBALS['log']->fatal('detalle_exp_activo', $detalle_exp_activo);
            $detalle_exp_aplazado   = $this->detalle_expediente($usuarios,'2');
            //$GLOBALS['log']->fatal('detalle_exp_aplazado', $detalle_exp_aplazado);
            $detalle_int_activo     = $this->detalle_interesado($usuarios,'1');
            //$GLOBALS['log']->fatal('detalle_int_activo', $detalle_int_activo);
            $detalle_int_aplazado   = $this->detalle_interesado($usuarios,'2');
            //$GLOBALS['log']->fatal('detalle_int_aplazado', $detalle_int_aplazado);
            $detalle_cnt_activo     = $this->detalle_contactado($usuarios,'1');
            //$GLOBALS['log']->fatal('detalle_cnt_activo', $detalle_cnt_activo);
            $detalle_cnt_aplazado   = $this->detalle_contactado($usuarios,'2');
            //$GLOBALS['log']->fatal('detalle_cnt_aplazado', $detalle_cnt_aplazado);
            $detalle_led_activo     = $this->detalle_lead($usuarios,'1');
            //$GLOBALS['log']->fatal('detalle_led_activo', $detalle_led_activo);
            $detalle_led_aplazado   = $this->detalle_lead($usuarios,'2');
            //$GLOBALS['log']->fatal('detalle_led_aplazado', $detalle_led_aplazado);

            $detalle_exp_activo     = array('expediente_activo' => $detalle_exp_activo);
            $detalle_exp_aplazado   = array('expediente_aplazado' => $detalle_exp_aplazado);
            $detalle_int_activo     = array('interesado_activo' => $detalle_int_activo);
            $detalle_int_aplazado   = array('interesado_aplazado' => $detalle_int_aplazado);
            $detalle_cnt_activo     = array('contactado_activo' => $detalle_cnt_activo);
            $detalle_cnt_aplazado   = array('contactado_aplazado' => $detalle_cnt_aplazado);
            $detalle_led_activo     = array('lead_activo' => $detalle_led_activo);
            $detalle_led_aplazado   = array('lead_aplazado' => $detalle_led_aplazado);

            $records = array_merge(
                $detalle_exp_activo, $detalle_exp_aplazado
                ,$detalle_int_activo,$detalle_int_aplazado
                ,$detalle_cnt_activo , $detalle_cnt_aplazado
              ,$detalle_led_activo,$detalle_led_aplazado
            );

            //$GLOBALS['log']->fatal('records2-json', json_encode($records));
            //$GLOBALS['log']->fatal('records2', $records);
            return $records;
        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    public function getusuarios($id_user,$tdirector, $posicion_operativa){
        $usuariosin ="";
        $equipo = [];
        $region = [];
        $tteams ="";

        $sqlteams = "SELECT REPLACE(uc.equipos_c,'^','\'') as equipos from users_cstm uc
        where id_c = '{$id_user}'";

        $result = $GLOBALS['db']->query($sqlteams);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $tteams = $row['equipos'];
        }
        //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
        //$GLOBALS['log']->fatal('tteams', $tteams);

        $pos = strrpos($posicion_operativa, "1");
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
            ( {$salidaequipos} ) and posicion_operativa_c like '%3%' -- puestousuario_c in ('5') -- ('1','2','3','4','5','6','20','33','44','55')
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

    public function detalle_expediente($usuarios,$statusProduct){
        //$GLOBALS['log']->fatal('usuarios detalle expediente',$usuarios);

        $query = "SELECT idCuenta,nombreCuenta, cuentas.idEmpresarial, cuentas.gpoEmpresarial, tipoCuenta,usuario.asesor,usuario.equipo_c,usuario.region_c ,subtipoCuenta,idOpp,oppNombre,oppEtapa,
		monto,  fecha_asignacion,daypas, tipo_producto, EstatusProducto, val_dias_20,val_dias_10,
		CASE WHEN solicitudes.val_dias_20 = 20 and solicitudes.monto > 10000000 THEN 0
		WHEN solicitudes.val_dias_20 = -20 and solicitudes.monto > 10000000 THEN 1
		WHEN solicitudes.val_dias_10 = 10 and (solicitudes.monto <= 10000000 ) THEN 0
		WHEN solicitudes.val_dias_10 = -10 and (solicitudes.monto <= 10000000) THEN 1
		END AS semaforo
            FROM (
	            SELECT a.id as idCuenta, a.name as nombreCuenta,aGpo.id as idEmpresarial, aGpo.name as gpoEmpresarial, ac.user_id_c, ac.tipo_registro_c, up.tipo_cuenta as tipoCuenta,
                up.subtipo_cuenta as subtipoCuenta,up.name nameProd, up.tipo_producto, upc.status_management_c as EstatusProducto
                FROM accounts a
                LEFT JOIN accounts aGpo on a.parent_id=aGpo.id
                INNER JOIN accounts_cstm ac on ac.id_c = a.id
                INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
                INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                WHERE up.tipo_cuenta = '2' and  up.subtipo_cuenta in ('8','10')
                and ac.user_id_c in ({$usuarios})
                and upc.status_management_c = '{$statusProduct}' -- '2'
                and tipo_producto = '1'
                and a.deleted = 0 and up.deleted = 0
            ) AS cuentas LEFT JOIN (
                SELECT app.account_id acc, opp.date_modified, TIMESTAMPDIFF(DAY, opp.date_modified, now()) as daypas,
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
		        	FROM accounts_opportunities app INNER JOIN opportunities opp on opp.id = app.opportunity_id
                    where  opp.assigned_user_id in ({$usuarios})
                    group by app.account_id order by app.account_id
                ) AS ultimos on ultimos.uac = app.account_id and ultimos.dayb = opp.date_modified
		        WHERE  oppcstm.tipo_producto_c = '1'
                group by app.account_id
                order by daypas
		    ) as solicitudes
	    on cuentas.idCuenta = solicitudes.acc,
        (select id, user_name,concat(first_name, ' ' ,last_name) asesor,equipo_c,region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
        where usuario.id = cuentas.user_id_c
        order by usuario.asesor , cuentas.nombreCuenta ";
        //$GLOBALS['log']->fatal('query exp',$query);
        /*if ($statusProduct == '2') {
            $query = $query . "where ( solicitudes.val_dias_20=20 and solicitudes.monto > 10000000) OR
            ( solicitudes.val_dias_10=10 and (solicitudes.monto <= 10000000 and solicitudes.monto > 0))";
        }
         */
        $result = $GLOBALS['db']->query($query);
        //$GLOBALS['log']->fatal('result', $result);
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $semaforoBool = ($row['semaforo']==1)?true:false;
            $records_in['records'][] = array(
                'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'],'idEmpresarial'=>$row['idEmpresarial'],'gpoEmpresarial'=>$row['gpoEmpresarial'], 'asesor' => $row['asesor'],
                'equipo' => $row['equipo_c'], 'region' =>$row['region_c'], 'tipoCuenta' => $row['tipoCuenta'],
                'subtipoCuenta' => $row['subtipoCuenta'], 'idOpp' => $row['idOpp'], 'oppNombre' => $row['oppNombre'],
                'oppEtapa' => $row['oppEtapa'], 'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $semaforoBool,
                'fecha_asignacion' => $row['fecha_asignacion'], 'Monto' => '$ ' . round($row['monto'], 2)
            );
        }
        //$GLOBALS['log']->fatal('records_in', $records_in);
        return $records_in;
    }

    public function detalle_interesado($usuarios,$statusProduct){
        //DASHLET SOLICITUDES SIN PROCESO
        $query = "SELECT
        cuentas.id as idCuenta, cuentas.name as nombreCuenta, usuario.asesor, usuario.equipo_c, usuario.region_c, cuentas.assigned_user_id, cuentas.user_id_c,
        cuentas.tipo_cuenta as tipoCuenta, cuentas.subtipo_cuenta as subtipoCuenta, cuentas.idEmpresarial, cuentas.gpoEmpresarial, solicitudes.idOpp as idOpp, solicitudes.oppNombre as oppNombre,
        solicitudes.date_modified fecha_asignacion,solicitudes.monto, solicitudes.daypas, solicitudes.tct_etapa_ddw_c, solicitudes.tct_estapa_subetapa_txf_c as oppEtapa,
        cuentas.status_management_c as EstatusProducto, cuentas.tipo_producto, solicitudes.tipo_producto_c,
        CASE WHEN solicitudes.date_modified < DATE_SUB(now(), INTERVAL 5 DAY) THEN 0
        WHEN solicitudes.date_modified > DATE_SUB(now(), INTERVAL 5 DAY) THEN 1
        END AS semaforo
            FROM
            (SELECT a.id, a.name ,a.assigned_user_id, aGpo.id as idEmpresarial, aGpo.name as gpoEmpresarial, ac.user_id_c, ac.tipo_registro_c, up.tipo_cuenta,
                  up.subtipo_cuenta,up.name nameProd, up.tipo_producto, upc.status_management_c
                  FROM accounts a
                  LEFT JOIN accounts aGpo on a.parent_id=aGpo.id
                  INNER JOIN accounts_cstm ac on ac.id_c = a.id
                  INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c
                  INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb
                  INNER JOIN uni_productos_cstm upc on upc.id_c = up.id
                  WHERE
                  up.tipo_cuenta = '2' and  up.subtipo_cuenta in ('7')
                  and ac.user_id_c  in ({$usuarios})
                  and upc.status_management_c = '{$statusProduct}'
                  and tipo_producto = '1'
                  and a.deleted = 0 and up.deleted = 0
            ) AS cuentas
            LEFT JOIN
            (SELECT
                    app.account_id acc, opp.date_modified, TIMESTAMPDIFF(DAY, opp.date_modified, now()) as daypas,
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
        on cuentas.id = solicitudes.acc,
        (select id, user_name,concat(first_name, ' ' ,last_name) asesor,equipo_c, region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
        where usuario.id = cuentas.user_id_c
        order by usuario.asesor ,  cuentas.name ";

        /*if ($statusProduct == 2) {
            $query = $query . "and opp.date_entered < DATE_SUB(now(), INTERVAL 5 DAY)";
        }*/
        //$GLOBALS['log']->fatal('query pi '. $query);
        $result = $GLOBALS['db']->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $semaforoBool = ($row['semaforo']==1)?true:false;
            $records_in['records'][] = array(
                'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'],'idEmpresarial' => $row['idEmpresarial'],'gpoEmpresarial' => $row['gpoEmpresarial'],
                'asesor' => $row['asesor'],'equipo' => $row['equipo_c'], 'region' => $row['region_c'] , 'tipoCuenta' => $row['tipoCuenta'],
                'subtipoCuenta' => $row['subtipoCuenta'], 'idOpp' => $row['idOpp'], 'oppNombre' => $row['oppNombre'],
                'oppEtapa' => $row['oppEtapa'], 'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $semaforoBool,
                'fecha_asignacion' => $row['fecha_asignacion'], 'Monto' => '$ ' . round($row['monto'], 2)
            );
        }

        return $records_in;
    }

    public function detalle_contactado($usuarios,$statusProduct){

        $query = "SELECT a.id as idCuenta, a.name as nombreCuenta,aGpo.id as idEmpresarial, aGpo.name as gpoEmpresarial, usuario.asesor ,usuario.equipo_c , usuario.region_c ,a.assigned_user_id, ac.user_id_c,
        up.tipo_cuenta as tipoCuenta, up.subtipo_cuenta as subtipoCuenta, upc.fecha_asignacion_c as fecha_asignacion,
        up.name, upc.status_management_c as EstatusProducto, up.tipo_producto,
        CASE WHEN upc.fecha_asignacion_c < DATE_SUB(now(), INTERVAL 5 DAY) THEN 0
        WHEN upc.fecha_asignacion_c > DATE_SUB(now(), INTERVAL 5 DAY) THEN 1
        END AS semaforo
        FROM accounts a
        LEFT JOIN accounts aGpo on a.parent_id=aGpo.id
        INNER JOIN accounts_cstm ac on ac.id_c = a.id and a.deleted = 0
        INNER JOIN accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = ac.id_c and aup.deleted = 0
        INNER JOIN uni_productos up on up.id = aup.accounts_uni_productos_1uni_productos_idb and up.deleted = 0
        INNER JOIN uni_productos_cstm upc on upc.id_c = up.id,
        (select id, user_name,concat(first_name, ' ' ,last_name) asesor,equipo_c,region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
        WHERE
        usuario.id = ac.user_id_c
        and up.tipo_cuenta = '2'
        and up.subtipo_cuenta in ('1','2')
        and ac.user_id_c in ({$usuarios})
        and up.tipo_producto = '1'
        and upc.status_management_c = '{$statusProduct}'
        order by usuario.asesor , a.name ";
        //$GLOBALS['log']->fatal('query cn '. $query);
        /*if ($estadoProducto == 2) {
            $query = $query . "and upc.fecha_asignacion_c < DATE_SUB(now(), INTERVAL 5 DAY)";
        }*/
         $result = $GLOBALS['db']->query($query);
         while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $semaforoBool = ($row['semaforo']==1)?true:false;
         $records_in['records'][] = array(
                'idCuenta' => $row['idCuenta'], 'nombreCuenta' => $row['nombreCuenta'],'idEmpresarial' => $row['idEmpresarial'],'gpoEmpresarial'=>$row['gpoEmpresarial'],
                'asesor' => $row['asesor'], 'equipo' => $row['equipo_c'], 'region' => $row['region_c'] , 'tipoCuenta' => $row['tipoCuenta'],
                'subtipoCuenta' => $row['subtipoCuenta'], 'fecha_asignacion' => $row['fecha_asignacion'],
                'EstatusProducto' => $row['EstatusProducto'], 'semaforo' => $semaforoBool
            );
        }
        return $records_in;

    }

    public function detalle_lead($usuarios,$statusProduct){
        //SEMAFORO 1 = EN TIEMPO - SEMAFORO 0 = ATRASADO
        $query = "SELECT idLead, nombre,asesor, equipo_c, region_c ,tipo , subtipo, fecha_asignacion,estatus, max(semaforo) semaforo
        FROM (
            SELECT DISTINCT l.id as idLead, l.assigned_user_id, lc.name_c as nombre, la.date_created as fecha_asignacion,
            lc.tipo_registro_c as tipo,lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
            CASE WHEN la.date_created < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
            WHEN la.date_created > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
            END AS semaforo
            FROM leads l
            INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
            inner join leads_audit la on la.parent_id = l.id
            where la.field_name='assigned_user_id'
            and la.after_value_string = l.assigned_user_id
            AND l.assigned_user_id in ({$usuarios})
            AND  lc.subtipo_registro_c in (1,2,3)
            AND (lc.status_management_c = '{$statusProduct}' or lc.status_management_c is null)
            AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
            UNION
            SELECT DISTINCT l.id as idLead, l.assigned_user_id, lc.name_c as nombre, c.date_end as fecha_asignacion,
            lc.tipo_registro_c as tipo, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
            CASE WHEN c.date_end < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
            WHEN c.date_end > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
            END AS semaforo
            FROM leads l
            INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
            INNER JOIN calls_leads cl on cl.lead_id = lc.id_c
            inner join calls c on c.id = cl.call_id AND c.deleted = 0
            WHERE l.assigned_user_id in ({$usuarios})
            AND lc.subtipo_registro_c in (1,2,3)
            AND (lc.status_management_c = '{$statusProduct}' or lc.status_management_c is null)
            AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
            UNION
            SELECT DISTINCT l.id as idLead, l.assigned_user_id, lc.name_c as nombre,  m.date_end as fecha_asignacion,
            lc.tipo_registro_c as tipo, lc.subtipo_registro_c as subtipo, lc.status_management_c as estatus,
            CASE WHEN m.date_end < DATE_SUB(now(), INTERVAL 10 DAY) THEN 0
            WHEN m.date_end > DATE_SUB(now(), INTERVAL 10 DAY) THEN 1
            END AS semaforo
            FROM leads l
            INNER JOIN leads_cstm lc ON lc.id_c = l.id AND l.deleted = 0
            inner join meetings_leads ml on ml.lead_id = lc.id_c
            inner join meetings m on m.id = ml.meeting_id AND m.deleted = 0
            WHERE l.assigned_user_id in ({$usuarios})
            AND lc.subtipo_registro_c in (1,2,3)
            AND (lc.status_management_c = '{$statusProduct}' or lc.status_management_c is null)
            AND (lc.contacto_asociado_c = 0 or lc.contacto_asociado_c is null)
        ) tablaLeads ,
        (select id, user_name,concat(first_name, ' ' ,last_name) asesor,equipo_c,region_c from users join users_cstm on users.id=users_cstm.id_c) as usuario
        WHERE
        usuario.id = tablaLeads.assigned_user_id
        group by idLead, nombre, subtipo, estatus
        order by asesor ,  nombre ";

        //$GLOBALS['log']->fatal('query lead '. $query);
        $result = $GLOBALS['db']->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $semaforoBool = ($row['semaforo']==1)?true:false;
            $records_in['records'][] = array(
            'idLead' => $row['idLead'], 'nombre' => $row['nombre'],
            'asesor' => $row['asesor'], 'equipo' => $row['equipo_c'],'region' => $row['region_c'],
            'tipo' => $row['tipo'] , 'subtipo' => $row['subtipo'], 'estatus' => $row['estatus'],
            'fecha_asignacion' => $row['fecha_asignacion'],'semaforo' => $semaforoBool);
        }

        return $records_in;
    }
}
