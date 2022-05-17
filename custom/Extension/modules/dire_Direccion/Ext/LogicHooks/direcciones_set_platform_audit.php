<?php

$hook_array['before_save'][] = Array(
    5,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios',
    'custom/modules/dire_Direccion/Direcciones_platform_user.php',
    'Direcciones_platform_user',
    'set_audit_user_platform_dire'
);