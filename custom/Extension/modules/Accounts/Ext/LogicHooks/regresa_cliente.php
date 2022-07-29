<?php
 /**
 * @author ECB
 * @date   03/02/2022
 */
$hook_array['before_save'][] = Array(
    25,
    'Regresa a Cliente si cambia a Prospecto',
    'custom/modules/Accounts/regresa_cliente.php',
    'regresa_cliente',
    'regresa_cliente'
);
