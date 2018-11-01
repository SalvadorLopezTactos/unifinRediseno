<?php

$hook_array['before_save'][] = Array(
    4,
    'User Private Team',
    'custom/modules/Users/DefaultTeam.php',
    'DefaultTeam',
    'new_user_created'
);
/*
$hook_array['after_save'][] = Array(
    1,
    'Asigna equipos de BO en caso de tener',
    'custom/modules/Users/DefaultTeam.php',
    'DefaultTeam', // name of the class
    'setBackOfficeTeam' // name of the function.

);*/

?>
