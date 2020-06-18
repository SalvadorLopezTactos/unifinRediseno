<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/05/20
 * Time: 03:23 PM
 */

$hook_array['after_save'][] = Array(
    1,
    'Habilitar el envío y actualización de cuentas bancarias a Cuentas en Mambu',//Just a quick comment about the logic of it
    'custom/modules/cta_cuentas_bancarias/CBMambu_hooks.php', //path to the logic hook
    'CBMambu_hook', // name of the class
    'Envia_mambu' // name of the function.
);

$hook_array['before_save'][] = Array(
    1,
    'Habilitar funcionalidad para duplicados en Cuentas_Bancarias',//Just a quick comment about the logic of it
    'custom/modules/cta_cuentas_bancarias/CBduplicated.php', //path to the logic hook
    'CBduplicados', // name of the class
    'duplicadosCB' // name of the function.
);

$hook_array['before_save'][] = Array(
    2,
    'Consume servicio para obtención de folio en Cuentas_Bancarias',//Just a quick comment about the logic of it
    'custom/modules/cta_cuentas_bancarias/mambu_idcorto.php', //path to the logic hook
    'Obtain_idCorto', // name of the class
    'idCortoCB' // name of the function.
);