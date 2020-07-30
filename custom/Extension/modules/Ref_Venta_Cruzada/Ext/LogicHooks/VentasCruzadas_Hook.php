<?php

$hook_array['after_save'][] = Array(
    1,
    'validar venta cruzada',
    'custom/modules/Ref_Venta_Cruzada/VentasCruzadas_class.php',
    'VentasCruzadas_class',
    'validacionAlta'
);