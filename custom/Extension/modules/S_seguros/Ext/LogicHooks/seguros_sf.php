<?php
/*
 * author: Tactos
 * Date: 27/07/2020
 * LH que conecta Sugar con SalesForce para Seguros
 */
/*$hook_array['before_save'][] = Array(
    1,
    'Conecta con SalesForce',
    'custom/modules/S_seguros/seguros_sf.php',
    'Seguros_SF',
    'getAccount'
);*/

$hook_array['before_save'][] = Array(
    1,
    'Conecta con Dynamics',
    'custom/modules/S_seguros/seguros_dynamics.php',
    'Seguros_dynamics',
    'getAccount'
);

