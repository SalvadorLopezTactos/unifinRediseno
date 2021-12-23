<?php
require_once("custom/Levementum/UnifinAPI.php");

class class_account_reus
{
    public function func_account_reus($bean = null, $event = null, $args = null)
    {
        $this->func_valida_correos($bean);
        $this->func_valida_telefonos($bean);
    }

    public function func_valida_correos($bean = null)
    {
        global $sugar_config, $db;
        $mailCuenta = false;
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
            $GLOBALS['log']->fatal($host);
            $resultado = $callApi->getDWHREUS($host);
            $GLOBALS['log']->fatal('Resultado DWH REUS CORREOS - CUENTAS: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {
                    //SOLO OBTENEMOS LOS CORREOS QUE EXISTEN EN REUS 
                    if ($val['existe'] == 'SI') {
                        foreach ($bean->emailAddress->addresses as $emailAddress) {

                            if ($emailAddress['email_address'] == $val['valor']) {
                                //ACTUALIZAMOS EL OPT_OUT DEL CORREO QUE SI EXISTE EN REUS 
                                $queryA = "UPDATE email_addresses SET opt_out = 1 WHERE id = '" . $emailAddress['email_address_id'] . "';";
                                $result = $db->query($queryA);
                            }
                        }
                    }
                }
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $queryB = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                $result = $db->query($queryB);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - CORREOS');
            }
        }
    }

    public function func_valida_telefonos($bean = null)
    {
        global $sugar_config, $db;
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
            $GLOBALS['log']->fatal($host);
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

                                    $queryC = "UPDATE tel_telefonos_cstm SET registro_reus_c = 1 WHERE id_c = '{$telefono->id}'";
                                    $result = $GLOBALS['db']->query($queryC);
                                }
                            }
                        }
                    }
                }
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                $queryD = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                $result = $db->query($queryD);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - TELEFONOS');
            }
        }
    }
}
