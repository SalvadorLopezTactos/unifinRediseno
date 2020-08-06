<?php

$hook_array['before_save'][] = Array(
    1,
    'validar venta cruzada',
    'custom/modules/Ref_Venta_Cruzada/VentasCruzadas_class.php',
    'VentasCruzadas_class',
    'validacionAlta'
);

$hook_array['after_save'][] = Array(
    2,
    'Envio de notificaciones para referencias válidas y canceladas',
    'custom/modules/Ref_Venta_Cruzada/ref_cruzadas_hooks.php',
    'Ref_Cruzadas_Hooks', // name of the class
    'enviaNotificaciones' // name of the function
);