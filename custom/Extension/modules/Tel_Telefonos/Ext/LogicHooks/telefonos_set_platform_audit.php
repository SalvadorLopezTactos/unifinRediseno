<?php

$hook_array['before_save'][] = Array(
    6,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios',
    'custom/modules/Tel_Telefonos/Telefonos_platform_user.php',
    'Telefonos_platform_user',
    'set_audit_user_platform_tel'
);