<?php
require_once("custom/Levementum/UnifinAPI.php");

class class_account_reus
{
    public function func_account_reus($bean = null, $event = null, $args = null)
    {
        $errorp = $this->func_valida_correos($bean);
        $errorp = $this->func_valida_telefonos($bean);

        if(!$errorp){
            $bean->pendiente_reus_c = 1;
        }else{
            $bean->pendiente_reus_c = 0;
        }
    }

    public function func_valida_correos($bean = null)
    {
        $noresp = null;
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
            //$GLOBALS['log']->fatal($host);
            $resultado = $callApi->getDWHREUS($host);
            //$resultado = '[{"valor":"caro1.huesca@gmail.com","existe":"NO"},{"valor":"caro.huesca@gmail.com","existe":"SI"},{"valor":"caro3.huesca@gmail.com","existe":"NO"},{"valor":"caro.huesca@gmail.com","existe":"SI"},{"valor":"0caro.huesca@gmail.com","existe":"NO"}]';
            //$resultado = json_decode($resultado, true);
            
            $GLOBALS['log']->fatal('Resultado DWH REUS CORREOS - CUENTAS: ' . json_encode($resultado));

            if ($resultado != "" && $resultado != null) {
                //RESULTADO DEL SERVICIO DWH REUS 
                foreach ($resultado as $key => $val) {
                    //SOLO OBTENEMOS LOS CORREOS QUE EXISTEN EN REUS
                    foreach ($bean->emailAddress->addresses as $key1=>$email_bean){
                        if ($email_bean['email_address'] == $val['valor'] && $bmail->deleted == false) {
                            //ACTUALIZAMOS EL OPT_OUT DEL CORREO QUE SI EXISTE EN REUS 
                            if ($val['existe'] == 'SI') {
                                //$queryA = "UPDATE email_addresses SET opt_out = 1 WHERE id = '" . $emailAddress['email_address_id'] . "';";
                                //$result = $db->query($queryA);
                                $bean->emailAddress->addresses[$key1]['opt_out'] = 1;
                            } else {
                                //$queryA1 = "UPDATE email_addresses SET opt_out = 0 WHERE id = '" . $emailAddress['email_address_id'] . "';";
                                //$result = $db->query($queryA1);
                                $bean->emailAddress->addresses[$key1]['opt_out'] = 0; 
                            }
                        }
                    }
                }
                $noresp = true;
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                //$queryB = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                //$result = $db->query($queryB);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - CORREOS');
                $noresp = false;
            }
        }
        return $noresp;
    }

    public function func_valida_telefonos($bean = null)
    {
        $noresp = null;
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
            //$GLOBALS['log']->fatal($host);
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

                                if ($val['existe'] == 'SI') {

                                    //$queryC = "UPDATE tel_telefonos_cstm SET registro_reus_c = 1 WHERE id_c = '{$telefono->id}'";
                                    //$result = $GLOBALS['db']->query($queryC);
                                    $telefono->registro_reus_c = 1;
                                    $telefono->save();
                                } else {
                                    //$queryC1 = "UPDATE tel_telefonos_cstm SET registro_reus_c = 0 WHERE id_c = '{$telefono->id}'";
                                    //$result = $GLOBALS['db']->query($queryC1);
                                    $telefono->registro_reus_c = 0;
                                    $telefono->save();
                                }
                            }
                        }
                    }
                }
                $noresp = true;
            } else {
                //Si el servicio de REUS no responde o presenta problemas se activa el check pendiente REUS
                //$queryD = "UPDATE accounts_cstm SET pendiente_reus_c = 1 WHERE id_c = '" . $bean->id . "';";
                //$result = $db->query($queryD);
                $GLOBALS['log']->fatal('SERVICIO DWH REUS NO RESPONDE - TELEFONOS');
                $noresp = false;
            }
        }
        return $noresp;
    }
}
