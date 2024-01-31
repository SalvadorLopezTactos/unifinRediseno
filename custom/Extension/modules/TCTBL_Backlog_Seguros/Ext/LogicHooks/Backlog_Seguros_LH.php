<?php

$hook_array['after_save'][] = array(
    1,
    'Establece nombre al registro de BACKLOG', //Se establece after_save para que el campo de No Backlog ya se encuentre lleno, ya que en before aún no se establece el campo
    'custom/modules/TCTBL_Backlog_Seguros/Backlog_Seguros_LH.php',
    'Backlog_Seguros_LH',
    'setNameRecord'
);