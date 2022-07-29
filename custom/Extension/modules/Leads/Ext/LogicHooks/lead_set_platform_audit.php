<?php

$hook_array['before_save'][] = Array(
    8,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios Leads',
    'custom/modules/Leads/Lead_platform_user.php',
    'Lead_platform_user',
    'set_audit_user_platform'
);