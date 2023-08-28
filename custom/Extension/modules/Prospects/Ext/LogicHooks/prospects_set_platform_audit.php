<?php

$hook_array['before_save'][] = Array(
    11,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniente de los servicios',
    'custom/modules/Prospects/Prospect_platform_user.php',
    'Prospect_platform_user',
    'set_audit_user_platform_prospect'
);
