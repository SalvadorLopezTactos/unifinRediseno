<?php

$hook_array['before_save'][] = Array(
    1,
    'validar venta cruzada',
    'custom/modules/Ref_Venta_Cruzada/ExistentesVentasCruzadas_class.php',
    'ExistentesVentasCruzadas_class',
    'BuscarExistentes'
);