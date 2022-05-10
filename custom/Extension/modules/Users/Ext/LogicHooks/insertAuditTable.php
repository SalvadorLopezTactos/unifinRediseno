<?php

$hook_array['before_save'][] = Array(
    4,
    'Función para insertar valores en tabla custom de auditoría de Usuarios (users_audit)',
    'custom/modules/Users/LogicHooks/insertAuditTable.php',
    'AuditTable',
    'insertAuditFields'
);
