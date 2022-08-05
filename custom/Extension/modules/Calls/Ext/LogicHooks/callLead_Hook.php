<?php

$hook_array['after_save'][] = Array(
    3,
    'cambiar estatus Lead',
    'custom/modules/Calls/callLead_class.php',
    'callLead_class',
    'LeadContactado'
);

$hook_array['after_save'][] = Array(
    2,
    'cambiar estatus Cuenta',
    'custom/modules/Calls/callLead_class.php',
    'callLead_class',
    'ProspectoContactado'
);
/*
$hook_array['after_save'][] = Array(
    4,
    'Convertir Lead',
    'custom/modules/Calls/callLead_class.php',
    'callLead_class',
    'ConvierteLead'
);
*/
$hook_array['before_save'][] = Array(
    1,
    'Funcion para guardar informacion del usuario logueado asi como asignado a la call CREADA.',
    'custom/modules/Calls/callLead_class.php',
    'callLead_class',
    'InfoCall'
);