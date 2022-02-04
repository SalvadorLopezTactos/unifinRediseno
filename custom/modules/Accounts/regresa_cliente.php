<?php
// ECB 03/02/2022 Regresa a Cliente si cambia a Prospecto
class regresa_cliente
{
    function regresa_cliente($bean, $event, $arguments)
    {
		if($bean->fetched_row['tipo_registro_cuenta_c'] == 3 && $bean->tipo_registro_cuenta_c == 2) {
			$bean->tipo_registro_cuenta_c = $bean->fetched_row['tipo_registro_cuenta_c'];
			$bean->subtipo_registro_cuenta_c = $bean->fetched_row['subtipo_registro_cuenta_c'];
			$bean->tct_tipo_subtipo_txf_c = $bean->fetched_row['tct_tipo_subtipo_txf_c'];
		}
    }
}