<?php
require_once("custom/Levementum/UnifinAPI.php");

class class_account_reus
{
    public function func_account_reus($bean = null, $event = null, $args = null)
    {
        global $db;

        $errorp = $this->func_valida_correos($bean);
        $errorp = $this->func_valida_telefonos($bean);

        if (!$errorp) {

            $sqlA = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '{$bean->id}'";
            $result = $db->query($sqlA);
            // $bean->pendiente_reus_c = 1;
            // $GLOBALS['log']->fatal("CHECK PENDIENTE SERVICIO REUS");
        } else {
            $sqlB = "UPDATE accounts_cstm SET pendiente_reus_c = 0 WHERE id_c = '{$bean->id}'";
            $result = $db->query($sqlB);
            // $bean->pendiente_reus_c = 0;
            // $GLOBALS['log']->fatal("UNCHECK PENDIENTE SERVICIO REUS");
        }
    }

    public function func_valida_correos($bean = null)
    {
        $noresp = null;
        global $sugar_config, $db, $current_user;
        $mailCuenta = false;
        $id_u_audit = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $event_id = create_guid();

        //API DHW REUS PARA CORREOS
        $callApi = new UnifinAPI();
        $host = $sugar_config['dwh_reus_correos'] . "?valor=";
        //SE OBTIENE LOS CORREOS DE LA CUENTA
        foreach ($bean->emailAddress->addresses as $emailAddress) {

            if ($emailAddress['email_address'] != "") {
                $host .= $emailAddress['email_address'] . ",";
                $mailCuenta = true;
            }
        }

        if ($mailCuenta == true) {

            $host = substr($host, 0, -1);
            // $GLOBALS['log']->fatal($host);
            $resultado = $callApi->getDWHREUS($host);
            
            $GLOBALS['log']->fatal('Resultado DWH REUS CORREOS - CUENTAS: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS
                foreach ($resultado as $key => $val) {
                    //SOLO OBTENEMOS LOS CORREOS QUE EXISTEN EN REUS
                    foreach ($bean->emailAddress->addresses as $key1 => $email_bean) {

                        if ($email_bean['email_address'] == $val['valor']) {
                            //ACTUALIZAMOS EL OPT_OUT DEL CORREO QUE SI EXISTE EN REUS
                            $previo = $email_bean['opt_out'];

                            if ($val['existe'] == 'SI') {

                                $queryA = "UPDATE email_addresses SET opt_out = 1 , invalid_email = 0 WHERE id = '{$email_bean['email_address_id']}'";
                                //$queryA = "UPDATE email_addresses SET opt_out = 1 WHERE id = '{$email_bean['email_address_id']}'";
                                $result = $db->query($queryA);
                                // $idmail = $emailAddress['email_address_id'];
                                //$bean->emailAddress->addresses[$key1]['opt_out'] = 1;
                                if ($previo != 1 || $previo != '1') {
                                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                                    VALUES ('{$id_u_audit}','{$email_bean['email_address_id']}','{$date}','{$current_user->id}','opt_out','bool','{$previo}',1,NULL,NULL,'{$event_id}',NULL)";
                                    $db->query($sqlInsert);
                                    $id_u_audit = create_guid();
                                    /*$sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                                    VALUES ('{$id_u_audit}','{$email_bean['email_address_id']}','{$date}','{$current_user->id}','invalid_email','bool','{$previo}',1,NULL,NULL,'{$event_id}',NULL)";
                                    $db->query($sqlInsert);*/
                                }
                            } else {

                                $queryB = "UPDATE email_addresses SET opt_out = 0 , invalid_email = 0 WHERE id = '{$email_bean['email_address_id']}'";
                                //$queryB = "UPDATE email_addresses SET opt_out = 0 WHERE id = '{$email_bean['email_address_id']}'";
                                $result = $db->query($queryB);

                                if ($previo != 0 || $previo != '0') {
                                    $sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                                    VALUES ('{$id_u_audit}','{$email_bean['email_address_id']}','{$date}','{$current_user->id}','opt_out','bool','{$previo}',0,NULL,NULL,'{$event_id}',NULL)";
                                    $db->query($sqlInsert);
                                    //$id_u_audit = create_guid();
                                    /*$sqlInsert = "INSERT INTO email_addresses_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                                    VALUES ('{$id_u_audit}','{$email_bean['email_address_id']}','{$date}','{$current_user->id}','invalid_email','bool','{$previo}',0,NULL,NULL,'{$event_id}',NULL)";
                                    $db->query($sqlInsert);*/
                                }
                                //$bean->emailAddress->addresses[$key1]['opt_out'] = 0;
                            }
                        }
                    }
                }
                $noresp = true;
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - CORREOS');
                $noresp = false;
            }
        } else {
            $noresp = true;
        }
        return $noresp;
    }

    public function func_valida_telefonos($bean = null)
    {
        $noresp = null;
        global $sugar_config, $db, $current_user;
        $id_u_audit = create_guid();
        $event_id = create_guid();
        $date = TimeDate::getInstance()->nowDb();
        $phoneCuenta = false;
        //API DHW REUS PARA TELEFONOS 
        $callApi = new UnifinAPI();
        $host = $sugar_config['dwh_reus_telefonos'] . "?valor=";
        //OBTENEMOS LOS TELEFONOS DE LA CUENTA
        if ($bean->load_relationship('accounts_tel_telefonos_1')) {
            $relatedTelefonos = $bean->accounts_tel_telefonos_1->getBeans();

            foreach ($relatedTelefonos as $telefono) {

                if ($telefono->telefono != "") {
                    $host .= $telefono->telefono . ",";
                    $phoneCuenta = true;
                }
            }
        }

        if ($phoneCuenta == true) {

            $host = substr($host, 0, -1);
            // $GLOBALS['log']->fatal($host);
            $resultado = $callApi->getDWHREUS($host);
            //$resultado = '[{"valor":"5518504488","existe":"SI"},{"valor":"5569783395","existe":"NO"}]';
            //$resultado = json_decode($resultado);
            $GLOBALS['log']->fatal('Resultado DWH REUS TELEFONOS - CUENTAS: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {
                    //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                    // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                    if ($bean->load_relationship('accounts_tel_telefonos_1')) {
                        $relatedTelefonos = $bean->accounts_tel_telefonos_1->getBeans();

                        foreach ($relatedTelefonos as $telefono) {

                            if ($telefono->telefono == $val['valor']) {

                                $telprevio = $telefono->registro_reus_c;
                                $beantel = BeanFactory::retrieveBean('Tel_Telefonos', $telefono->id);
                                if ($val['existe'] == 'SI') {

                                    //$queryC = "UPDATE tel_telefonos_cstm SET registro_reus_c = 1 WHERE id_c = '{$telefono->id}'";
                                    //$GLOBALS['db']->query($queryC);
                                    $beantel->registro_reus_c = 1;
                                    $beantel->save();
                                    // $GLOBALS['log']->fatal("TELEFONO REUS");
                                    //Establece nuevo registro en tabla de auditoria
                                    $id_u_audit = create_guid();
                                    if ($telprevio != 1 || $telprevio != '1') {
                                        $sqlInsert = "INSERT INTO tel_telefonos_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                                        VALUES ('{$id_u_audit}','{$telefono->id}','{$date}','{$current_user->id}','registro_reus_c','bool','{$telprevio}',1,NULL,NULL,'{$event_id}',NULL)";
                                        $db->query($sqlInsert);
                                    }
                                }
                                if ($val['existe'] == 'NO') {
                                    $beantel->registro_reus_c = 0;
                                    $beantel->save();
                                    //$queryD = "UPDATE tel_telefonos_cstm SET registro_reus_c = 0 WHERE id_c = '{$telefono->id}'";
                                    //$GLOBALS['db']->query($queryD);
                                    // $GLOBALS['log']->fatal("TELEFONO NORMAL");
                                    // $beantel->registro_reus_c = 0;
                                    $id_u_audit = create_guid();
                                    if ($telprevio != 0 || $telprevio != '0') {
                                        $sqlInsert = "INSERT INTO tel_telefonos_audit (id,parent_id,date_created,created_by,field_name,data_type,before_value_string,after_value_string,before_value_text,after_value_text,event_id,date_updated)
                                        VALUES ('{$id_u_audit}','{$telefono->id}','{$date}','{$current_user->id}','registro_reus_c','bool','{$telprevio}',0,NULL,NULL,'{$event_id}',NULL)";
                                        $db->query($sqlInsert);
                                    }
                                }
                            }
                        }
                    }
                }
                $noresp = true;
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $GLOBALS['log']->fatal('SERVICIO DWH REUS CUENTAS NO RESPONDE - TELEFONOS');
                $noresp = false;
            }
        } else {
            $noresp = true;
        }
        return $noresp;
    }
}
