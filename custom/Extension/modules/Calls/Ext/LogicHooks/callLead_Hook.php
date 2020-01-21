<?php

$hook_array['after_save'][] = Array(
    3,
    'cambiar estatus Lead',
    'custom/modules/Calls/callLead_class.php',
    'callLead_class',
    'LeadContactado'
);