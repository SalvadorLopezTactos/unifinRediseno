<?php

$hook_array['before_save'][] = array(
    1,
    'Establece nombre al registro de BACKLOG', //Just a quick comment about the logic of it
    'custom/modules/TCTBL_Backlog_Seguros/Backlog_Seguros_LH.php', //path to the logic hook
    'Backlog_Seguros_LH', // name of the class
    'setNameRecord' // name of the function.
);