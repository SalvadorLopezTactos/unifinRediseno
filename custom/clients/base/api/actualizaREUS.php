<?php
/**
 * Created by erick.cruz@tactos.com.mx.
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class actualizaREUS extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'existsAccounts' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('actualizaReus'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'actualiza_Reus',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Actualizacion de teléfonos y correos de REUS',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            )

        );
    }


    public function actualiza_Reus($api, $args)
    {
        $salida = array();
        $aux = array();
        $est = 0;
        $est1 = 0;
        $telefonosReus = $args['telefonosReus'];
        $telefonosNoReus = $args['telefonosNoReus'];
        $correosReus = $args['correosReus'];
        $correosNoReus = $args['correosNoReus'];

        $current_user = $this->user_api();
        
        if(count($telefonosReus)){
            //$GLOBALS['log']->fatal("telefonosReus: " . print_r($telefonosReus, true));
            $est = $this->actualiza_telefono_lead($telefonosReus, "SI" , $current_user);
            $est1 = $this->actualiza_telefono_cuenta($telefonosReus, "SI" , $current_user);
            array_push ($aux , $est);
            array_push ($aux , $est1);
        }
        if(count($telefonosNoReus)){
            //$GLOBALS['log']->fatal("telefonosNoReus: " . print_r($telefonosNoReus, true));
            $est = $this->actualiza_telefono_lead($telefonosNoReus, "NO" , $current_user);
            $est1 = $this->actualiza_telefono_cuenta($telefonosNoReus, "NO" , $current_user);
            array_push ($aux , $est);
            array_push ($aux , $est1);
        }
        if(count($correosReus)){
            //$GLOBALS['log']->fatal("correosReus: " . print_r($correosReus, true));
            $est = $this->actualiza_email($correosReus, "SI" , $current_user);
            array_push ($aux , $est);
        }
        if(count($correosNoReus)){
            //$GLOBALS['log']->fatal("correosNoReus: " . print_r($correosNoReus, true));
            $est = $this->actualiza_email( $correosNoReus, "NO" , $current_user);
            array_push ($aux , $est);
        }

        if(array_search(400, $aux) > 0){
            $salida["estado"] = 400;
            $salida["detalle"] = "Error con los datos enviados";
        } else if(array_search(500, $aux) > 0){
            $salida["estado"] = 500;
            $salida["detalle"] = "Error recuperado en algun try-catch";
        } else{
            $salida["estado"] = 200;
            $salida["detalle"] = "CRM Actualizado Correctamente";
        }   

        return $salida;
    }

    public function actualiza_telefono_lead($telefonos, $reus , $current_user){
        $estado = 0;
        global $sugar_config, $db; 

        $id_u_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $event_id = create_guid();
        $tels = "";
        for($i = 0; $i < count($telefonos); $i++) {
            $tels = $tels .'"'.$telefonos[$i].'",';
        }
        $tels = substr($tels, 0, -1);

        $sql = "SELECT l.id, l.phone_home , lc.c_registro_reus_c , l.phone_mobile , 
            lc.m_registro_reus_c ,l.phone_work ,lc.o_registro_reus_c FROM leads l INNER JOIN leads_cstm lc ON l.id = lc.id_c
            WHERE l.phone_home in ({$tels}) OR l.phone_mobile in ({$tels}) OR l.phone_work in ({$tels})";

        $GLOBALS['log']->fatal("sql: " . $sql );
        try{
            $result = $db->query($sql);
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Exception " . $ex);
            $estado = 400;
        }

        try{
        if($estado != 400 ){
          while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            $c_registro_reus_c = $row['c_registro_reus_c'];
            $m_registro_reus_c = $row['m_registro_reus_c'];
            $o_registro_reus_c = $row['o_registro_reus_c'];

            if ($reus == 'SI') {
                foreach ($telefonos as $key => $val) {
                    //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                    // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                    if ($row['phone_mobile'] == $val && $row['m_registro_reus_c'] != '1') {
                        $query3 = "UPDATE leads_cstm SET m_registro_reus_c = 1 WHERE id_c = '{$row['id']}'";
                        $db->query($query3);
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO leads_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','m_registro_reus_c','bool','{$m_registro_reus_c}',1,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                    if ($row['phone_home'] == $val && $row['c_registro_reus_c'] != '1') {
                        $query3 = "UPDATE leads_cstm SET c_registro_reus_c = 1 WHERE id_c = '{$row['id']}'";
                        $db->query($query3);
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO leads_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','c_registro_reus_c','bool','{$c_registro_reus_c}',1,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                    if ($row['phone_work'] == $val && $row['o_registro_reus_c'] != '1') {
                        $query3 = "UPDATE leads_cstm SET o_registro_reus_c = 1 WHERE id_c = '{$row['id']}'";
                        $db->query($query3);
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO leads_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','o_registro_reus_c','bool','{$o_registro_reus_c}',1,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                }
            }

            if ($reus == 'NO') {
                foreach ($telefonos as $key => $val) {
                    //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                    // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                    if ($row['phone_mobile'] == $val && $row['m_registro_reus_c'] != '0') {
                        $query3 = "UPDATE leads_cstm SET m_registro_reus_c = 0 WHERE id_c = '{$row['id']}'";
                        $db->query($query3);
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO leads_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','m_registro_reus_c','bool','{$m_registro_reus_c}',0,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                    if ($row['phone_home'] == $val && $row['c_registro_reus_c'] != '0') {
                        $query3 = "UPDATE leads_cstm SET c_registro_reus_c = 0 WHERE id_c = '{$row['id']}'";
                        $db->query($query3);
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO leads_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','c_registro_reus_c','bool','{$c_registro_reus_c}',0,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                    if ($row['phone_work'] == $val && $row['o_registro_reus_c'] != '0') {
                        $query3 = "UPDATE leads_cstm SET o_registro_reus_c = 0 WHERE id_c = '{$row['id']}'";
                        $db->query($query3);
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO leads_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','o_registro_reus_c','bool','{$o_registro_reus_c}',0,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                }
            }
          }
          $estado = 200;
        }
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Exception " . $ex);
            $estado = 500;
        }
        return $estado;
    }

    public function actualiza_telefono_cuenta($telefonos, $reus , $current_user){
        $estado = 0;
        global $sugar_config, $db;
        //$current_user = $this->user_api();
        $id_u_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $event_id = create_guid();
        $tels = "";
        for($i = 0; $i < count($telefonos); $i++) {
            $tels = $tels .'"'.$telefonos[$i].'",';
        }
        $tels = substr($tels, 0, -1);

        $sql = "SELECT a.id acid, tt.id tid ,tt.telefono, ttc.registro_reus_c, tt.date_entered , tt.date_modified 
        from accounts a
        inner join accounts_tel_telefonos_1_c attc on a.id = attc.accounts_tel_telefonos_1accounts_ida 
        inner join tel_telefonos tt on attc.accounts_tel_telefonos_1tel_telefonos_idb = tt.id
        inner join tel_telefonos_cstm ttc on ttc.id_c = tt.id 
        WHERE tt.telefono in ({$tels})";

        $GLOBALS['log']->fatal("actualiza_telefono_cuenta: " . $sql );
        try{
            $result = $db->query($sql);
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Exception " . $ex);
            $estado = 400;
        }

        try{
        if($estado != 400 ){
          while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            $registro_reus_c = $row['registro_reus_c'];

            if ($reus == 'SI') {
                foreach ($telefonos as $key => $val) {
                    //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                    // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                    if ($row['telefono'] == $val && $row['registro_reus_c'] != '1') {
                        $queryC = "UPDATE tel_telefonos_cstm SET registro_reus_c = 1 WHERE id_c = '{$row['tid']}'";
                        $GLOBALS['db']->query($queryC);
                        //Establece nuevo registro en tabla de auditoria
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO tel_telefonos_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['tid']}','{$date}','{$current_user}','registro_reus_c','bool','{$registro_reus_c}',1,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                }
            }

            if ($reus == 'NO') {
                foreach ($telefonos as $key => $val) {
                    //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                    // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                    if ($row['telefono'] == $val && $row['registro_reus_c'] != '0') {
                        $queryC = "UPDATE tel_telefonos_cstm SET registro_reus_c = 0 WHERE id_c = '{$row['tid']}'";
                        $GLOBALS['db']->query($queryC);
                        //Establece nuevo registro en tabla de auditoria
                        $id_u_audit = create_guid();
                        $sqlInsert = "INSERT INTO tel_telefonos_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['tid']}','{$date}','{$current_user}','registro_reus_c','bool','{$registro_reus_c}',0,NULL,NULL,'{$event_id}',NULL)";
                        $db->query($sqlInsert);
                    }
                }    
            }
          }
          $estado = 200;
        }
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Exception " . $ex);
            $estado = 500;
        }
        return $estado;
    }

    public function actualiza_email($emails, $reus , $current_user){
        $estado = 0;
        global $sugar_config, $db;
        //$current_user = $this->user_api();
        $mailCuenta = false;
        $id_u_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $event_id = create_guid();
        $correos = "";
        for($i = 0; $i < count($emails); $i++) {
            $correos = $correos .'"'. strtolower($emails[$i]).'",';
        }
        $correos = substr($correos, 0, -1);

        $sql = "SELECT  DISTINCT(email_addresses.id) , email_addresses.email_address,email_addresses.opt_out ,
            email_addresses.invalid_email
            FROM email_addresses 
            JOIN email_addr_bean_rel eabr
            ON eabr.email_address_id = email_addresses.id
            WHERE eabr.bean_module in ('Leads','Accounts')
            AND email_addresses.email_address in ($correos)
            AND eabr.deleted = 0";

        $GLOBALS['log']->fatal("sql: " . $sql );
        try{
            $result = $db->query($sql);
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Exception " . $ex);
            $estado = 400;
        }

        try{
        if($estado != 400 ){
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            $previoopt = $row['opt_out'];
            $previoinv = $row['invalid_email'];

            //$GLOBALS['log']->fatal("id: " . $row['id']. "email: " . $row['email_address'] );
            //$GLOBALS['log']->fatal("previoopt: " . $previoopt. "previoinv: " . $previoinv );
            if ($reus == 'SI') {
                if($previoopt != '1' && $previoinv != '1'){
                    //$queryA = "UPDATE email_addresses SET opt_out = 1 , invalid_email = 1 WHERE id = '{$row['id']}'";
                    $queryA = "UPDATE email_addresses SET opt_out = 1 WHERE id = '{$row['id']}'";
                    //$GLOBALS['log']->fatal("queryA: " . $queryA );
                    $db->query($queryA);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','opt_out','bool','{$previoopt}',1,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    $id_u_audit = create_guid();
                    /*$sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','invalid_email','bool','{$previoinv}',1,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    */
                }
            }

            if ($reus == 'NO') {
                if($previoopt != '0' && $previoinv != '0'){
                    $queryA = "UPDATE email_addresses SET opt_out = 0 , invalid_email = 0 WHERE id = '{$row['id']}'";
                    //$GLOBALS['log']->fatal("queryA: " . $queryA );
                    $db->query($queryA);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','opt_out','bool','{$previoopt}',0,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user}','invalid_email','bool','{$previoinv}',0,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                }
            }
        }
        $estado = 200;
        }
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal("Exception " . $ex);
            $estado = 500;
        }
        return $estado;
    }

    public function user_api(){
        $id_user = "";
        global $app_list_strings;
        $lista_plataformas_audit=$app_list_strings['plataformas_habilitadas_auditoria_list'];
        //$plataforma=$GLOBALS['service']->platform;
        $plataforma = 'dwh';
        //Obtiene el usuario relacionado a la plataforma
        $list_platform_user = $app_list_strings['plataforma_usuario_grupo_list'];
        //$GLOBALS['log']->fatal("plataforma: " . $plataforma );
        //$GLOBALS['log']->fatal("plataformas_array: " . print_r($lista_plataformas_audit, true));

        if(isset($GLOBALS['service']->platform) && $GLOBALS['service']->platform != ""){        
            $plataformas_array=array();
    
            foreach ($lista_plataformas_audit as $clave => $valor) {
               array_push($plataformas_array,$clave);
            }
    
            //Se establece tabla de auditoria solo para plataformas que existen en la lista plataformas habilitadas para    auditoria
            //$GLOBALS['log']->fatal("array: " . print_r($plataformas_array, true));
            if(in_array($plataforma,$plataformas_array)){
                //Obtiene el nombre de usuario dependiendo la plataforma
                $nombre_usuario_gpo=$list_platform_user[$plataforma];
                //$GLOBALS['log']->fatal("nombre_usuario_gpo: " , $nombre_usuario_gpo);
                //Obtiene id del nombre de usuario
                $query_user_gpo="SELECT id FROM users WHERE user_name='{$nombre_usuario_gpo}'";
                $id_user = $GLOBALS['db']->getOne($query_user_gpo);
                /*$resultQueryUserGpo = $db->query($query_user_gpo);
                while ($row = $db->fetchByAssoc($resultQueryUserGpo)){
                    $id_user = $row['id'];
                }*/
            }
        }
        $GLOBALS['log']->fatal("id_user: " . $id_user );
        return $id_user;
    }
}