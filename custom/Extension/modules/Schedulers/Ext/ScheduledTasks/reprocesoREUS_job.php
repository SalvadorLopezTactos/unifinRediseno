<?php

array_push($job_strings, 'reprocesoREUS_job');
function reprocesoREUS_job()
{
    //Se obtienen valores del config, ip
    global $sugar_config, $db;
    //Host mail
    $hostmail = $sugar_config['dwh_reus_correos'] . "?valor=";
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job reproceso REUS: Inicia');
    $callApi = new UnifinAPI(); //clase con las funciones de REUS

    //recupera leads con pendiente REUS
    $query = "SELECT id_c as id, 'lead' as tipo FROM LEADS_CSTM where pendiente_reus_c = 1";
    $result = $GLOBALS['db']->query($query);
    //recupera cuentas con pendiente REUS
    $query = "SELECT id_c as id, 'cuenta' as tipo FROM ACCOUNTS_CSTM where pendiente_reus_c = 1";
    $result2 = $GLOBALS['db']->query($query);

    $GLOBALS['log']->fatal('result',$result);
    $GLOBALS['log']->fatal('Jresult', $result2);

    $result = array_merge($result, $result2);

    $GLOBALS['log']->fatal('result',$result);

    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
        if($row['tipo'] == 'lead'){
            $bean = BeanFactory::retrieveBean('Leads', $row['id']);
        }else{
            $bean = BeanFactory::retrieveBean('Accounts', $row['id']);
        }

        //Validacion REUS mail
        foreach ($bean->emailAddress->addresses as $emailAddress) {
            $hostmail .= $emailAddress['email_address'].",";
        }
        $hostmail = substr($host,0,-1);
        $resultadomail = $callApi->getDWHREUS($host);
        
        if ($resultadomail != "" && $resultadomail != null) {
            //RESULTADO DEL SERVICIO DWH REUS 
            foreach ($resultadomail as $key => $val) {
    
                if ($val['existe'] == 'SI') {
                    foreach ($bean->emailAddress->addresses as $emailAddress) {
                        if ($emailAddress['email_address'] == $val['valor']){
                            $query = "UPDATE email_addresses SET opt_out = 1 WHERE id = '".$emailAddress['email_address_id']."';";
                                $result = $db->query($query); 
                        }
                    }
                }
            }
        }else{
            //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
            $query = "UPDATE leads_cstm SET pendiente_reus_c = 1 WHERE id_c = '".$bean->id."';";
            $result = $db->query($query);
            $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - CORREOS');
        }
    
        if($row['tipo'] == 'lead'){
            //Validacion REUS telefono
            $host = $sugar_config['dwh_reus_telefonos'] . "?valor=";
            $host .= ($bean->phone_mobile != "")? $bean->phone_mobile : "";
    
            if ($bean->phone_mobile != "") {
                $host .= ($bean->phone_home != "")? ",".$bean->phone_home : "";
            } else {
                $host .= ($bean->phone_home != "")? $bean->phone_home : "";
            }
            if ($bean->phone_mobile == "" && $bean->phone_home == "") {
                $host .= ($bean->phone_work != "")? $bean->phone_work : "";
            } else {
                $host .= ($bean->phone_work != "")? ",".$bean->phone_work : "";
            }
    
            $resultado = $callApi->getDWHREUS($host);
    
            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {
                    if ($val['existe'] == 'SI') {
                        //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                        // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                        if ($bean->phone_mobile == $val['valor']) {                        
                            $query = "UPDATE leads_cstm SET m_registro_reus_c = 1 WHERE id_c = '".$bean->id."';";
                            $result = $db->query($query);                        
                        }
                        if ($bean->phone_home == $val['valor']) {                        
                            $query = "UPDATE leads_cstm SET c_registro_reus_c = 1 WHERE id_c = '".$bean->id."';";
                            $result = $db->query($query);                        
                        }
                        if ($bean->phone_work == $val['valor']) {                        
                            $query = "UPDATE leads_cstm SET o_registro_reus_c = 1 WHERE id_c = '".$bean->id."';";
                            $result = $db->query($query);                        
                        }
                    }
                }
                
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $query = "UPDATE leads_cstm SET pendiente_reus_c = 1 WHERE id_c = '".$bean->id."';";
                $result = $db->query($query);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - TELEFONOS'); 
            }
        }
        if($row['tipo'] == 'cuenta'){
            $host = $sugar_config['dwh_reus_telefonos'] . "?valor=";
            //OBTENEMOS LOS TELEFONOS DE LA CUENTA
            if ($bean->load_relationship('accounts_tel_telefonos_1')) {
                $relatedTelefonos = $bean->accounts_tel_telefonos_1->getBeans();
                foreach ($relatedTelefonos as $telefono) {
                    $host .= $telefono->telefono.",";
                }
            }
    
            $host = substr($host,0,-1);
            $resultado = $callApi->getDWHREUS($host);
            $GLOBALS['log']->fatal('Resultado DWH REUS TELEFONOS - CUENTAS: ' . json_encode($resultado));
    
            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {
    
                    if ($val['existe'] == 'SI') {
                        //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                        // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                        if ($bean->load_relationship('accounts_tel_telefonos_1')) {
                            $relatedTelefonos = $bean->accounts_tel_telefonos_1->getBeans();
                            
                            foreach ($relatedTelefonos as $telefono) {
    
                                if ($telefono->telefono == $val['valor']) {
    
                                    $sql = "UPDATE tel_telefonos_cstm SET registro_reus_c = 1 WHERE id_c = '{$telefono->id}'";
                                    $result = $GLOBALS['db']->query($sql);
                                }
                            }
                        }
                    }
                }
                
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $query = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '".$bean->id."';";
                $result = $db->query($query);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - TELEFONOS'); 
            }
        }
    }

    return true;
}