<?php

$hook_array['before_save'][] = Array(
    23,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios',
    'custom/modules/Accounts/Account_platform_user.php',
    'Account_platform_user',
    'set_audit_user_platform'
);