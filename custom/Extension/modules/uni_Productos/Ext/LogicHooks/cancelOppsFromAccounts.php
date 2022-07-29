<?php
/**
 * Created by Salvador Lopez.
 * User: salvador.lopez@tactos.com.mx
 */
$hook_array['before_save'][] = Array(
    1,
    'Al establcer el Estatus por Producto como Cancelado, se cancelan sus solicitudes relacionadas',
    'custom/modules/uni_Productos/uni_Productos_hooks.php',
    'uni_Productos_hooks',
    'cancelarOppsFromAccounts'
);

$hook_array['before_save'][] = Array(
    2,
    'Regresa a Cliente si cambia a Prospecto',
    'custom/modules/uni_Productos/regresa_cliente1.php',
    'regresa_cliente1',
    'regresa_cliente1'
);
