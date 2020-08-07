<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 22/07/20
 * Time: 08:52 AM
 */



class asesor_operacion_class
{

    function asesor_operacion_function($bean, $event, $arguments)
    {
        $GLOBALS['log']->fatal("solicitudes --> ".$bean->asesor_operacion_c . " asignado  " .$bean->assigned_user_id ." usuario " . $bean->user_id_c);

        if(empty($bean->asesor_operacion_c))
        {
            //$bean->asesor_operacion_c=$bean->assigned_user_id;
            $bean->user_id_c=$bean->assigned_user_id;

        }
    }

}
