<?php

$hook_array['before_save'][] = Array(
    31,
    'Notifica cambio de Razón social / Nombre, Apellidos o Dirección fiscal en caso de que RFC sea el mismo',
    'custom/modules/Accounts/Account_Hooks.php',
    'Account_Hooks',
    'cambioRazonSocial'
);