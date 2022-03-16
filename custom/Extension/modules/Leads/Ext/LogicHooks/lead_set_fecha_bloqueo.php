<?php
// Creado por: Salvador Lopez <salvador.lopez@tactos.com.mx>
$hook_array['before_save'][] = Array(
    10,
    'Si el valor de origen se establece desde un servicio externo, antes de cambiar el valor de origen, se valida que la fecha de bloqueo se haya cumplido, en otro caso, no aplica el cambio en el campo origen',
    'custom/modules/Leads/Fecha_bloqueo_origen.php',
    'Fecha_bloqueo_origen',
    'valida_fecha_bloqueo'
);
$hook_array['before_save'][] = Array(
    11,
    'Establece fecha de bloqueo para Origen',
    'custom/modules/Leads/Fecha_bloqueo_origen.php',
    'Fecha_bloqueo_origen',
    'establece_fecha_bloqueo'
);

