<?php
require_once("custom/Levementum/UnifinAPI.php");

class class_lead_reus
{
    public function func_lead_reus($bean = null, $event = null, $args = null)
    {
        $this->func_valida_telefonos($bean);
        $this->func_valida_correos($bean);
    }

    public function func_valida_correos($bean = null)
    {
        global $sugar_config, $db;
        $callApi = new UnifinAPI();
        $host = $sugar_config['dwh_reus_correos'] . "?valor=";

        foreach ($bean->emailAddress->addresses as $emailAddress) {
            $host .= $emailAddress['email_address'].",";
        }
        $host = substr($host,0,-1);

        $GLOBALS['log']->fatal($host);
        $resultado = $callApi->getDWHREUS($host);
        $GLOBALS['log']->fatal('Resultado DWH REUS CORREOS: ' . json_encode($resultado));

        if ($resultado != "" && $resultado != null) {
            //RESULTADO DEL SERVICIO DWH REUS 
            foreach ($resultado as $key => $val) {

                if ($val['existe'] == 'SI') {
                    foreach ($bean->emailAddress->addresses as $emailAddress) {
                        if ($emailAddress['email_address'] == $val['valor']){

                            $query = "UPDATE email_addresses SET opt_out = 1 WHERE id = '".$emailAddress['email_address_id']."';";
                            $result = $db->query($query); 
                        }
                    }
                }
            }        
        
        } else {
            //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
            $query = "UPDATE leads_cstm SET pendiente_reus_c = 1 WHERE id_c = '".$bean->id."';";
            $result = $db->query($query);
            $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - CORREOS');
        }

    }

    public function func_valida_telefonos($bean = null)
    {
        global $sugar_config, $db;
        $callApi = new UnifinAPI();
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

        $GLOBALS['log']->fatal($host);
        $resultado = $callApi->getDWHREUS($host);
        $GLOBALS['log']->fatal('Resultado DWH REUS TELEFONOS: ' . json_encode($resultado));

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
}
