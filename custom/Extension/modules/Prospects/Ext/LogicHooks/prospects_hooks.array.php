<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 2/05/2022
 * Time: 4:24 PM
 */
$hook_array['after_save'][] = Array(
    1,
    'Guarda direcciones en Publico Objetivo',//Just a quick comment about the logic of it
    'custom/modules/Prospects/po_direcciones_class.php', //path to the logic hook
    'po_direcciones_class', // name of the class
    'po_direcciones_function' // name of the function.
);