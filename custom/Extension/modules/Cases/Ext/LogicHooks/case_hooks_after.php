<?php

$hook_array['before_save'][] = Array(
    1,
    'Asigna fecha caso creado',
    'custom/modules/Cases/Seguimiento_Hook.php',
    'Seguimiento_Hook',
    'Fecha_Seguimiento'
);

$hook_array['before_save'][] = Array(
    2,
    'Establece equipos privados para manipular visibilidad del Caso',
    'custom/modules/Cases/Seguimiento_Hook.php',
    'Seguimiento_Hook',
    'set_private_team'
);

$hook_array['before_save'][] = Array(
    3,
    'Establece asignado y Responsable interno con base a lo seleccionado en área y equipo de soporte',
    'custom/modules/Cases/Seguimiento_Hook.php',
    'Seguimiento_Hook',
    'set_asignado_responsable'
);