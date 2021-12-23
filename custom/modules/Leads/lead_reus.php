<?php
require_once("custom/Levementum/UnifinAPI.php");

class class_lead_reus
{
    public function func_lead_reus($bean = null, $event = null, $args = null)
    {
        $this->func_valida_correos($bean);
        $this->func_valida_telefonos($bean);
    }

    public function func_valida_correos($bean = null)
    {
        global $sugar_config, $db;
        $mailLead = false;
        //API DHW REUS PARA CORREOS 
        $callApi = new UnifinAPI();
        $host = $sugar_config['dwh_reus_correos'] . "?valor=";
        //SE OBTIENE LOS CORREOS DEL LEAD
        foreach ($bean->emailAddress->addresses as $emailAddress) {

            if ($emailAddress['email_address'] != "") {
                $host .= $emailAddress['email_address'] . ",";
                $mailLead = true;
            }
        }
        
        if ($mailLead == true) {

            $host = substr($host, 0, -1);
            $GLOBALS['log']->fatal($host);
            $resultado = $callApi->getDWHREUS($host);
            $GLOBALS['log']->fatal('Resultado DWH REUS CORREOS - LEADS: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {
                    //SOLO OBTENEMOS LOS CORREOS QUE EXISTEN EN REUS 
                    if ($val['existe'] == 'SI') {
                        
                        foreach ($bean->emailAddress->addresses as $emailAddress) {
                            
                            if ($emailAddress['email_address'] == $val['valor']) {
                                //ACTUALIZAMOS EL OPT_OUT DEL CORREO QUE SI EXISTE EN REUS 
                                $query1 = "UPDATE email_addresses SET opt_out = 1 WHERE id = '" . $emailAddress['email_address_id'] . "';";
                                $result = $db->query($query1);
                            }
                        }
                    }
                }
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $query2 = "UPDATE leads_cstm SET pendiente_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                $result = $db->query($query2);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - CORREOS');
            }
        }
    }

    public function func_valida_telefonos($bean = null)
    {
        global $sugar_config, $db;
        $phoneLead = false;
        //API DHW REUS PARA TELEFONOS 
        $callApi = new UnifinAPI();
        $host = $sugar_config['dwh_reus_telefonos'] . "?valor=";
        //OBTENEMOS LOS TELEFONOS DEL LEAD
        if ($bean->phone_mobile != "") {
            $host .= $bean->phone_mobile;
            $phoneLead = true;
        }
        if ($bean->phone_mobile != "" && $bean->phone_home != "") {
            $host .= "," . $bean->phone_home;
            $phoneLead = true;
        } else {

            if ($bean->phone_home != "") {
                $host .= $bean->phone_home;
                $phoneLead = true;
            }
        }
        if ($bean->phone_mobile == "" && $bean->phone_home == "" && $bean->phone_work != "") {
            $host .= $bean->phone_work;
            $phoneLead = true;
        } else {

            if ($bean->phone_work != "") {
                $host .= "," . $bean->phone_work;
                $phoneLead = true;
            }
        }
        
        if ($phoneLead == true) {
            
            $GLOBALS['log']->fatal($host);
            $resultado = $callApi->getDWHREUS($host);
            $GLOBALS['log']->fatal('Resultado DWH REUS TELEFONOS - LEADS: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {

                    if ($val['existe'] == 'SI') {
                        //VALIDA EN LOS TELEFONOS DE MOBILE, CASA Y OFICINA SI ESTAN REGISTRADOS EN REUS 
                        // Y ACTIVA EL CHECK DEL REGISTRO REUS EN CRM
                        if ($bean->phone_mobile == $val['valor']) {
                            $query3 = "UPDATE leads_cstm SET m_registro_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                            $result = $db->query($query3);
                        }
                        if ($bean->phone_home == $val['valor']) {
                            $query4 = "UPDATE leads_cstm SET c_registro_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                            $result = $db->query($query4);
                        }
                        if ($bean->phone_work == $val['valor']) {
                            $query5 = "UPDATE leads_cstm SET o_registro_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                            $result = $db->query($query5);
                        }
                    }
                }
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $query6 = "UPDATE leads_cstm SET pendiente_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                $result = $db->query($query6);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - TELEFONOS');
            }
        }
    }
}
