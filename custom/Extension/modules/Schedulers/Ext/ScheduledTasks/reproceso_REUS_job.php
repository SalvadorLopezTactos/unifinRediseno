<?php

array_push($job_strings, 'reproceso_REUS_job');
function reproceso_REUS_job()
{
    //Se obtienen valores del config, ip
    global $sugar_config, $db;
    $error = false;
    //Host mail
    $hostmail = $sugar_config['dwh_reus_correos'] . "?valor=";
        
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job reproceso REUS: Inicia');
    $callApi = new UnifinAPI(); //clase con las funciones de REUS
    $respuesta = array();

    //recupera leads con pendiente REUS
    $query = "SELECT id_c as id FROM LEADS_CSTM where pendiente_reus_c = 1";
    $result = $GLOBALS['db']->query($query);
    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
        $pila = array(
            'id' => $row['id'],
            'tipo'  => "lead"
        );
        array_push($respuesta, $pila);
    }
    //recupera cuentas con pendiente REUS
    $query = "SELECT id_c as id FROM ACCOUNTS_CSTM where pendiente_reus_c = 1";
    $result2 = $GLOBALS['db']->query($query);
    while($row = $GLOBALS['db']->fetchByAssoc($result2) ){
        $pila = array(
            'id' => $row['id'],
            'tipo'  => "cuenta"
        );
        array_push($respuesta, $pila);
    }
    
    $GLOBALS['log']->fatal('result',$respuesta);

    foreach($respuesta as $valor ){
        
        if($valor['tipo'] == 'lead'){
            $bean = BeanFactory::retrieveBean('Leads', $valor['id']);
        }else{
            $bean = BeanFactory::retrieveBean('Accounts', $valor['id']);
        }

        //Validacion REUS mail
        foreach ($bean->emailAddress->addresses as $emailAddress) {
            $hostmail .= $emailAddress['email_address'].",";
        }
        $hostmail = substr($hostmail,0,-1);
        $resultadomail = $callApi->getDWHREUS($hostmail);
        $GLOBALS['log']->fatal('res',$resultadomail);
        if ($resultadomail != "" && $resultadomail != null) {
            //RESULTADO DEL SERVICIO DWH REUS 
            foreach ($resultadomail as $key => $val) {
                foreach ($bean->emailAddress->addresses as $key1=>$email_bean){
                    if ($email_bean['email_address'] == $val['valor'] && $bmail->deleted == false) {
                        if ($val['existe'] == 'SI') {
            //$query = "UPDATE email_addresses SET opt_out = 1 WHERE id = '".$emailAddress['email_address_id']."'";
              //              $result = $db->query($query); 
                            $bean->emailAddress->addresses[$key1]['opt_out'] = 1;
                        }
                        if ($val['existe'] == 'NO') {
                            //$query = "UPDATE email_addresses SET opt_out = 0 WHERE id = '".$emailAddress['email_address_id']."'";
                            //$result = $db->query($query); 
                            $bean->emailAddress->addresses[$key1]['opt_out'] = 0;
                        }
                    }
                }
            }
            $bean->save();
        }else{
            $error = true;
        }
    
        if($valor['tipo'] == 'lead'){
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
                            //$query = "UPDATE leads_cstm SET m_registro_reus_c = 1 WHERE id_c = '".$bean->id."';";
                            //$result = $db->query($query);
                            $bean->m_registro_reus_c = 1;
                        }
                        if ($bean->phone_home == $val['valor']) {                        
                            //$query = "UPDATE leads_cstm SET c_registro_reus_c = 1 WHERE id_c = '".$bean->id."';";
                            //$result = $db->query($query);
                            $bean->c_registro_reus_c = 1;
                        }
                        if ($bean->phone_work == $val['valor']) {                        
                            //$query = "UPDATE leads_cstm SET o_registro_reus_c = 1 WHERE id_c = '".$bean->id."';";
                            //$result = $db->query($query);
                            $bean->o_registro_reus_c = 1;
                        }
                    }
                    if ($val['existe'] == 'NO') {
                        //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                        // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                        if ($bean->phone_mobile == $val['valor']) {                        
                            //$query = "UPDATE leads_cstm SET m_registro_reus_c = 0 WHERE id_c = '".$bean->id."';";
                            //$result = $db->query($query);
                            $bean->m_registro_reus_c = 0;                     
                        }
                        if ($bean->phone_home == $val['valor']) {                        
                            //$query = "UPDATE leads_cstm SET c_registro_reus_c = 0 WHERE id_c = '".$bean->id."';";
                            //$result = $db->query($query);
                            $bean->c_registro_reus_c = 0;                      
                        }
                        if ($bean->phone_work == $val['valor']) {                        
                            //$query = "UPDATE leads_cstm SET o_registro_reus_c = 0 WHERE id_c = '".$bean->id."';";
                            //$result = $db->query($query);
                            $bean->o_registro_reus_c = 0;
                        }
                    }
                }
                $bean->save();               
            } else {
                $error = true;
            }
        }
        if($valor['tipo'] == 'cuenta'){
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
                    //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                    // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                    if ($bean->load_relationship('accounts_tel_telefonos_1')) {
                        $relatedTelefonos = $bean->accounts_tel_telefonos_1->getBeans();
                    
                        foreach ($relatedTelefonos as $telefono) {
                            if ($telefono->telefono == $val['valor']) {
                                //recupera bean del telefono
                                $beantel = BeanFactory::retrieveBean('tel_telefonos', $telefono->id);
                                if ($val['existe'] == 'SI') {
                                    //$sql = "UPDATE tel_telefonos_cstm SET registro_reus_c = 1 WHERE id_c = '{$telefono->id}'";
                                    //$result = $GLOBALS['db']->query($sql);
                                    $beantel->registro_reus_c = 1;
                                    $beantel->save();
                                }
                                if ($val['existe'] == 'NO') {
                                    //$sql = "UPDATE tel_telefonos_cstm SET registro_reus_c = 0 WHERE id_c = '{$telefono->id}'";
                                    //$result = $GLOBALS['db']->query($sql);
                                    $beantel->registro_reus_c = 0;
                                    $beantel->save();
                                }
                            }
                        }
                    }
                }
            } else {
                $error = true;
            }
        }

        if($error){
            //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
            if($valor['tipo'] == 'lead'){
                //$query = "UPDATE leads_cstm SET pendiente_reus_c = 1 WHERE id_c = '".$bean->id."';";
                //$result = $db->query($query);
                $bean->pendiente_reus_c = 1;
            }
            if($valor['tipo'] == 'cuenta'){
                //$query = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '".$bean->id."';";
                //$result = $db->query($query);
                $bean->pendiente_reus_c = 1;
            }
            $bean->pendiente_reus_c = 1;
        }else{
            //Si el servicio de REUS respondio correctamente a telefono y correo
            if($valor['tipo'] == 'lead'){
                //$query = "UPDATE leads_cstm SET pendiente_reus_c = 0 WHERE id_c = '".$bean->id."';";
                //$result = $db->query($query);
                $bean->pendiente_reus_c = 0;
            }
            if($valor['tipo'] == 'cuenta'){
                //$query = "UPDATE accounts_cstm SET pendiente_reus_c = 0 WHERE id_c = '".$bean->id."';";
                //$result = $db->query($query);
                $bean->pendiente_reus_c = 0;
            }
            $bean->save();
        }
    }

    $GLOBALS['log']->fatal('Job reproceso REUS: Fin');
    return true;
}