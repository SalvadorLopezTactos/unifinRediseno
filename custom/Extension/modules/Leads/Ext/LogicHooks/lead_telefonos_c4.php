<?php
// ECB 07/01/2022 Consulta Servicio de C4 para Teléfonos
$hook_array['before_save'][] = Array(
    9,
    'Consulta Servicio de C4 para Teléfonos',
    'custom/modules/Leads/lead_telefonos_c4.php',
    'lead_telefonos_c4',
    'lead_telefonos_c4'
);