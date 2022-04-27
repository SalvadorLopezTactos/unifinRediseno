<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 14/02/19
 * Time: 04:56 PM
 */

$hook_array['before_save'][] = Array(
    1,
    'Guarda referencia como nueva cuenta, tipo LEAD',
    'custom/modules/minut_Minutas/min_Minuta_referencias.php',
    'Minuta_Referencias', // name of the class
    'savereferencia' // name of the function
);

