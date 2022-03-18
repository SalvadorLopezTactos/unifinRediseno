<?php
// Creado por: Salvador Lopez <salvador.lopez@tactos.com.mx>
$hook_array['before_save'][] = Array(
    26,
    'Genera solicitudes dummy en caso de que la cuenta venga desde Onboarding',
    'custom/modules/Accounts/Account_fecha_bloqueo_origen.php',
    'Account_fecha_bloqueo_origen',
    'solicitudes_dummy_onboarding'
);

$hook_array['before_save'][] = Array(
    27,
    'Si el valor de origen se establece desde un servicio externo, antes de cambiar el valor de origen, se valida que la fecha de bloqueo se haya cumplido, en otro caso, no aplica el cambio en el campo origen',
    'custom/modules/Accounts/Account_fecha_bloqueo_origen.php',
    'Account_fecha_bloqueo_origen',
    'valida_fecha_bloqueo_origen'
);

$hook_array['before_save'][] = Array(
    28,
    'Establece fecha de bloqueo para Origen',
    'custom/modules/Accounts/Account_fecha_bloqueo_origen.php',
    'Account_fecha_bloqueo_origen',
    'establece_fecha_bloqueo_account'
);

