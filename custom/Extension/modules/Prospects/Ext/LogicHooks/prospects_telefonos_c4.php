<?php
// Adrian Arauz 2022-04-28 Consulta Servicio de C4 para Teléfonos
$hook_array['before_save'][] = Array(
    9,
    'Consulta Servicio de C4 para Teléfonos',
    'custom/modules/Prospects/prospects_telefonos_c4.php',
    'prospects_telefonos_c4',
    'prospects_telefonos_c4'
);