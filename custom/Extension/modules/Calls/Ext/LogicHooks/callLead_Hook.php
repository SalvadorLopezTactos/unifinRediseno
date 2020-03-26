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