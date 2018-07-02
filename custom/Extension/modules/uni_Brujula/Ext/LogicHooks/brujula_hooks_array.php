<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/19/2016
 * Time: 9:34 AM
 */


$hook_array['before_save'][] = Array(
    1,
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