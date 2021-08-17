<?php

$hook_array['before_save'][] = Array(
    2,
    'validar venta cruzada',
    'custom/modules/Ref_Venta_Cruzada/VentasCruzadas_class.php',
    'VentasCruzadas_class',
    'validacionAlta'
);

$hook_array['before_save'][] = Array(
    3,
    'verificar equipos de asesores origen y destino para establecer referencia como No válida',
    'custom/modules/Ref_Venta_Cruzada/VentasCruzadas_class.php',
    'VentasCruzadas_class',
    'validaEquiposAsesores'
);

$hook_array['before_save'][] = Array(
    4,
    'Establece registro en tabla de auditoría dependiendo de la plataforma proveniento de los servicios de Referencia Bancaria',
    'custom/modules/Ref_Venta_Cruzada/Ref_VtaCruzada_platform.php',
    'Ref_VtaCruzada_platform_user',
    'set_audit_user_platform'
);

$hook_array['after_save'][] = Array(
    3,
    'Envio de notificaciones para referencias válidas y canceladas',
    'custom/modules/Ref_Venta_Cruzada/ref_cruzadas_hooks.php',
    'Ref_Cruzadas_Hooks', // name of the class
    'enviaNotificaciones' // name of the function
);

$hook_array['after_save'][] = Array(
    4,
    'Envio de notificación No Válida del producto Leasing para Alejandro de la Vega',
    'custom/modules/Ref_Venta_Cruzada/ref_cruzadas_hooks.php',
    'Ref_Cruzadas_Hooks',
    'enviaNotificacionRefNoValida'
);