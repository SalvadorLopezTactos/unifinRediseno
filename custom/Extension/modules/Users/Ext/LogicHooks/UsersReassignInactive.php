<?php

$hook_array['before_save'][] = Array(
    5,
    'Al detectar que un usuario se Inactiva, se reasignan sus registros asignados para que estén disponibles en el protocolo de reasignación de Leads',
    'custom/modules/Users/LogicHooks/ReassignRecordsForProtocolo.php',
    'ReassignRecordsForProtocolo',
    'reassignRecordsForUserInactive'
);
