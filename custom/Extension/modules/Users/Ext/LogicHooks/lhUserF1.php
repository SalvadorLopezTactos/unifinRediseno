<?php

$hook_array['before_save'][] = Array(
    2,
    'Función para cambiar contraseña',
    'custom/modules/Users/LogicHooks/changeCustomPassword.php',
    'class_changeCustomPassword',
    'method_changeCustomPassword'
);

$hook_array['before_save'][] = Array(
    3,
    'Función para validar id ingresados en los cambios UD uni2 y unics',
    'custom/modules/Users/LogicHooks/IDUsuarios.php',
    'UsuarioID',
    'validausuariosid'
);

?>
