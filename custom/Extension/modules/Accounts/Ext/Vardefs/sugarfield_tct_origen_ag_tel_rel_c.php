<?php
 // created: 2020-05-26 10:15:53
$dictionary['Account']['fields']['tct_origen_ag_tel_rel_c'] = array (
    'labelValue' => 'Agente Telefónico',
    'dependency' => 'or(equal($detalle_origen_c,"2"),equal($detalle_origen_c,"8"),equal($detalle_origen_c,"6"),equal($detalle_origen_c,"5"),equal($detalle_origen_c,"4"),equal($detalle_origen_c,"3"),equal($detalle_origen_c,"9"),equal($detalle_origen_c,"1"),equal($detalle_origen_c,"10"))',
    'table' => 'users',
    'module' => 'Employees'
);
 ?>