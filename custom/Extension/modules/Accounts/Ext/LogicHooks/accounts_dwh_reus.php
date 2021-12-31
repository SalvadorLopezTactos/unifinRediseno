<?php

$hook_array['after_save'][] = Array(
    23,
    'LOGIC HOOK PARA DWH REUS',//Just a quick comment about the logic of it
    'custom/modules/Accounts/account_reus.php', //path to the logic hook
    'class_account_reus', // name of the class
    'func_account_reus' // name of the function.
);