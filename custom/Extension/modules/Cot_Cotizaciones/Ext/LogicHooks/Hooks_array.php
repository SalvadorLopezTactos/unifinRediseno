<?php
 /**
 *  Adrian Arauz
 *   10/08/2022
 */
$hook_array['before_save'][] = Array(
    1,
    'Envio de Cotizaciones a Dynamics desde Cotizaciones-CRM',
    'custom/modules/Cot_Cotizaciones/Cotizaciones_dynamics.php',
    'Cotizaciones_dynamics',
    'envioDynamics'
);