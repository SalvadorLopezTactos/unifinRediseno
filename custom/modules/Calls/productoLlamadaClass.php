<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class producto_llamada_class
{
    function producto_asesor_function($bean, $event, $arguments)
    {
        //Asigna producto del asesor asignado a la llamada
        if ($bean->assigned_user_id != "" || $bean->assigned_user_id != null) {

            $asesorAsignado = BeanFactory::getBean('Users', $bean->assigned_user_id);
            $tipoProducto = $asesorAsignado->tipodeproducto_c;
            // $GLOBALS['log']->fatal('Producto de asesor asignado '.$tipoProducto);

            //Valida si el usuario tiene producto
            if (($bean->producto_c == "" || $bean->producto_c == null) &&
                ($tipoProducto != "" || $tipoProducto != null)) {

                $bean->producto_c = $tipoProducto;
                //$GLOBALS['log']->fatal('Asigna Producto Principal del Asesor Asignado a la Llamada');
            }
        }
    }
}
