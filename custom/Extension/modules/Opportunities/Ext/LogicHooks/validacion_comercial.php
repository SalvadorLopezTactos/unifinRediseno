<?php
/**
 * Created by tactos.
 * User: ECB
 * Date: 20/05/2022
 */

$hook_array['before_save'][] = Array(
    26,
    'Prende campo Aplica Validación Comercial',
    'custom/modules/Opportunities/validacion_comercial.php',
    'validacion_comercial',
    'validacion_comercial'
);