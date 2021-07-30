<?php

$hook_array['before_save'][] = Array(
    1,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios Referencia Bancaria',
    'custom/modules/RefBa_Referencia_Bancaria/Ref_Bancaria_platform.php',
    'Ref_Bancaria_platform_user',
    'set_audit_user_platform'
);

