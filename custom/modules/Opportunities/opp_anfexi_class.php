<?php

class anfexi_class
{
    function anfexi_function($bean = null, $event = null, $args = null)
    {        
        /**********Funcion para asignar asesor uniclick de cuenta, cuando la solicitud no tenga asesor**********/
        $beanCuenta = BeanFactory::retrieveBean('Accounts', $bean->account_id, array('disable_row_level_security' => true));
        
        if ($bean->assigned_user_id == '' || $bean->assigned_user_id == null){
            // $GLOBALS['log']->fatal("Asigna Asesor Uniclick en la Solicitud: ". $beanCuenta->user_id7_c);
            $bean->assigned_user_id = $beanCuenta->user_id7_c; //Se asigna al Asesor Uniclick en la Solicitud
            
        }
    }
}