<?php

$hook_array['before_save'][] = Array(
    2,
    'Función para cambiar contraseña',
    'custom/modules/Users/LogicHooks/changeCustomPassword.php',
    'class_changeCustomPassword',
    'method_changeCustomPassword'
);

?>
