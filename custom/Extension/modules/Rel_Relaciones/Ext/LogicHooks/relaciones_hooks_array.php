<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/12/2015
 * Time: 9:40 PM
 */
$hook_array['before_save'][] = Array(
    1,
    'Set the name of the record',
    'custom/modules/Rel_Relaciones/Rel_Relaciones_Hooks.php',
    'Rel_Relaciones_Hooks',
    'SetName'
);
$hook_array['after_save'][] = Array(
    1,
    'Insertar Relacion en UNICS',
    'custom/modules/Rel_Relaciones/Rel_Relaciones_Hooks.php',
    'Rel_Relaciones_Hooks',
    'insertarRelacionenUNICS'
);
$hook_array['after_delete'][] = Array(
    1,
    'Actualiza Relacion en UNICS',
    'custom/modules/Rel_Relaciones/Rel_Relaciones_Hooks.php',
    'Rel_Relaciones_Hooks',
    'insertarRelacionenUNICS'
);

