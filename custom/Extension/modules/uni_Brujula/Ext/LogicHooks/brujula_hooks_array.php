<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/19/2016
 * Time: 9:34 AM
 */


$hook_array['before_save'][] = Array(
    1,
    'Valida que no exista ya una brujula antes de guardar',
    'custom/modules/uni_Brujula/brujula_Hooks.php',
    'brujula_Hooks',
    'validafechas'
);

$hook_array['before_save'][] = Array(
    2,
    'guardar las citas',
    'custom/modules/uni_Brujula/brujula_Hooks.php',
    'brujula_Hooks',
    'guardarCitas'
);

$hook_array['after_save'][] = Array(
    1,
    'set Name',
    'custom/modules/uni_Brujula/brujula_Hooks.php',
    'brujula_Hooks',
    'setName'
);