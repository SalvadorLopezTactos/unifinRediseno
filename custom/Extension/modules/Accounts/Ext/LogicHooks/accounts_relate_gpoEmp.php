<?php

$hook_array['after_relationship_add'][] = Array(
    1,
    'LOGIC HOOK PARA agregar detalle de grupo empresarial',//Just a quick comment about the logic of it
    'custom/modules/Accounts/account_relation.php', //path to the logic hook
    'class_account_relation', // name of the class
    'add_gpo_empresarial' // name of the function.
);

$hook_array['after_save'][] = Array(
    1,
    'LOGIC HOOK para actualizar detalle de grupo empresarial padre',//Just a quick comment about the logic of it
    'custom/modules/Accounts/account_relation.php', //path to the logic hook
    'class_account_relation', // name of the class
    'update_gpo_empresarial' // name of the function.
);
