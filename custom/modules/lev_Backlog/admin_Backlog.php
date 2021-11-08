<?php

class class_Backlog_Admin
{
    function func_Backlog_Admin($bean = null, $event = null, $args = null)
    {
        //SOLO SE EJECUTA EN LA CREACIÓN DEL BACKLOG
        if (!$args['isUpdate']) {

            if ($bean->account_id_c != '') {

                $rel_cuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id_c);
                $check_lumo = $rel_cuenta->lumo_c;

                $GLOBALS['log']->fatal("BACKLOG - ACTUALIZA LUMO SI ESTA ACTIVO EN LA CUENTA RELACIONADA: " . $bean->account_id_c . " LUMO: " . $check_lumo);

                if ($check_lumo == 1) {
                    $bean->lumo_cuentas_c = 1;
                    // $GLOBALS['log']->fatal("LUMO BACKLOG ". $bean->lumo_cuentas_c);
                }
            }
        }
    }
}
