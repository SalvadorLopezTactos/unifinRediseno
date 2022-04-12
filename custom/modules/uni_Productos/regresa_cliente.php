<?php
// Regresa a Cliente si cambia a Prospecto
class regresa_cliente
{
    function regresa_cliente($bean, $event, $arguments)
    {
		if($bean->fetched_row['tipo_cuenta'] == 3 && $bean->tipo_cuenta == 2) {
			$bean->tipo_cuenta = $bean->fetched_row['tipo_cuenta'];
			$bean->subtipo_cuenta = $bean->fetched_row['subtipo_cuenta'];
			$bean->tipo_subtipo_cuenta = $bean->fetched_row['tipo_subtipo_cuenta'];
		}
    }
}