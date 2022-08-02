<?php
/**
 * Created by tactos.
 * User: JG
 * Date: 22/07/20
 * Time: 08:40 AM
 */

$hook_array['before_save'][] = Array(
    22,
    'Copia usuario asignado al campo asesor de operacion',
    'custom/modules/Opportunities/asesor_operacion.php',
    'asesor_operacion_class',
    'asesor_operacion_function'
);