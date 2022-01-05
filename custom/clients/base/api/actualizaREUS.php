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
        $est = 0;
        $telefonosReus = $args['telefonosReus'];
        $telefonosNoReus = $args['telefonosNoReus'];
        $correosReus = $args['correosReus'];
        $correosNoReus = $args['correosNoReus'];
        /*
        if(count($telefonosReus)){
            $GLOBALS['log']->fatal("telefonosReus: " . print_r($telefonosReus, true));
            array_push ($salida , ["telefonosReus" => array()]);
        }
        if(count($telefonosNoReus)){
            $GLOBALS['log']->fatal("telefonosNoReus: " . print_r($telefonosNoReus, true));
            array_push ($salida , ["telefonosNoReus" => array()]);
        }
        if(count($correosReus)){
            //$GLOBALS['log']->fatal("correosReus: " . print_r($correosReus, true));
            $est = $this->actualiza_email($correosReus, "SI");
            if( $est  == 200){
                
                $aux = ["estado" => array(), "detalle" => array()];
                $aux["estado"] = $est ;
                $aux["detalle"] = "CRM Actualizado Correctamente";

                array_push ($salida , ["correosReus" => $aux]);
            }
            if( $est  == 400){
                
                $aux = ["estado" => array(), "detalle" => array()];
                $aux["estado"] = $est ;
                $aux["detalle"] = "Error con los datos enviados";

                array_push ($salida , ["correosReus" => $aux]);
            }
            if( $est  == 500){
                
                $aux = ["estado" => array(), "detalle" => array()];
                $aux["estado"] = $est ;
                $aux["detalle"] = "Error recuperado en algun try-catch";

                array_push ($salida , ["correosReus" => $aux]);
            }
        }
        if(count($correosNoReus)){
            //$GLOBALS['log']->fatal("correosNoReus: " . print_r($correosNoReus, true));
            $est = $this->actualiza_email( $correosNoReus, "NO");
            if( $est  == 200){
                
                $aux = ["estado" => array(), "detalle" => array()];
                $aux["estado"] = $est ;
                $aux["detalle"] = "CRM Actualizado Correctamente";

                array_push ($salida , ["correosNoReus" => $aux]);
            }

            if( $est  == 400){
                
                $aux = ["estado" => array(), "detalle" => array()];
                $aux["estado"] = $est ;
                $aux["detalle"] = "Error con los datos enviados";

                array_push ($salida , ["correosReus" => $aux]);
            }
            if( $est  == 500){
                
                $aux = ["estado" => array(), "detalle" => array()];
                $aux["estado"] = $est ;
                $aux["detalle"] = "Error recuperado en algun try-catch";

                array_push ($salida , ["correosReus" => $aux]);
            }
        }
        */
        $salida["estado"] = 200;
        $salida["detalle"] = "CRM Actualizado Correctamente";

        return $salida;
    }

    public function actualiza_telefono($emails, $reus){
        $estado = 0;
        global $sugar_config, $db, $current_user;
        $mailCuenta = false;
        $id_u_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $event_id = create_guid();
        $correos = "";
        for($i = 0; $i < count($emails); $i++) {
            $correos = $correos .'"'.$emails[$i].'",';
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

        //$GLOBALS['log']->fatal("sql: " . $sql );
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
                    $queryA = "UPDATE email_addresses SET opt_out = 1 , invalid_email = 1 WHERE id = '{$row['id']}'";
                    $GLOBALS['log']->fatal("queryA: " . $queryA );
                    $db->query($queryA);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','opt_out','bool','{$previoopt}',1,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','invalid_email','bool','{$previoinv}',1,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                }
            }

            if ($reus == 'NO') {
                if($previoopt != '0' && $previoinv != '0'){
                    $queryA = "UPDATE email_addresses SET opt_out = 0 , invalid_email = 0 WHERE id = '{$row['id']}'";
                    $GLOBALS['log']->fatal("queryA: " . $queryA );
                    $db->query($queryA);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','opt_out','bool','{$previoopt}',0,NULL,NULL,'{$event_id}',NULL)";
                    $GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','invalid_email','bool','{$previoinv}',0,NULL,NULL,'{$event_id}',NULL)";
                    $GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
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

    public function actualiza_email($emails, $reus){
        $estado = 0;
        global $sugar_config, $db, $current_user;
        $mailCuenta = false;
        $id_u_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $event_id = create_guid();
        $correos = "";
        for($i = 0; $i < count($emails); $i++) {
            $correos = $correos .'"'.$emails[$i].'",';
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

        //$GLOBALS['log']->fatal("sql: " . $sql );
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
                    $queryA = "UPDATE email_addresses SET opt_out = 1 , invalid_email = 1 WHERE id = '{$row['id']}'";
                    $GLOBALS['log']->fatal("queryA: " . $queryA );
                    $db->query($queryA);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','opt_out','bool','{$previoopt}',1,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','invalid_email','bool','{$previoinv}',1,NULL,NULL,'{$event_id}',NULL)";
                    //$GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                }
            }

            if ($reus == 'NO') {
                if($previoopt != '0' && $previoinv != '0'){
                    $queryA = "UPDATE email_addresses SET opt_out = 0 , invalid_email = 0 WHERE id = '{$row['id']}'";
                    $GLOBALS['log']->fatal("queryA: " . $queryA );
                    $db->query($queryA);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','opt_out','bool','{$previoopt}',0,NULL,NULL,'{$event_id}',NULL)";
                    $GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
                    $db->query($sqlInsert);
                    $id_u_audit = create_guid();
                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                        VALUES ('{$id_u_audit}','{$row['id']}','{$date}','{$current_user->id}','invalid_email','bool','{$previoinv}',0,NULL,NULL,'{$event_id}',NULL)";
                    $GLOBALS['log']->fatal("sqlInsert: " . $sqlInsert );
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
}