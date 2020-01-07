<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class checkCancelado
{
    function subTipoCancelado($bean, $event, $arguments)
    {

        /******CUANDO CANCELAS EL LEAD EN AUTOMATICO PASA A SUBTIPO CANCELADO******/
        if ($bean->lead_cancelado_c == 1 && $bean->motivo_cancelacion_c != '') {

            $bean->subtipo_registro_c = "3";
            $bean->save();
        }
    }
}
