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
    'Establece asignado y Responsable interno con base a lo seleccionado en área y equipo de soporte',
    'custom/modules/Cases/Seguimiento_Hook.php',
    'Seguimiento_Hook',
    'set_asignado_responsable'
);

$hook_array['before_save'][] = Array(
    3,
    'Establece equipos privados para manipular visibilidad del Caso',
    'custom/modules/Cases/Seguimiento_Hook.php',
    'Seguimiento_Hook',
    'set_private_team'
);

$hook_array['before_save'][] = Array(
   4,
   'Evita guardado de registro en caso de que se relacione una cuenta bloqueada',
   //Hsace referencia a archivo dentro de Opportunities para no generar uno nuevo ya que se reutiliza la funcionalidad para Cases
   'custom/modules/Opportunities/Check_Bloqueo_Cuenta_Opp.php',
   'Check_Bloqueo_Cuenta_Opp',
   'verifica_cuenta_bloqueada_opp'
);
