<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 15/07/2020
 */

/*
Definición de LH para recuperar vía de comunicación de mensaje y actualiza a Origen de Lead.
*/

/*
1.- Al guardar Conversación Chattigo;
*/
$hook_array['before_save'][] = Array(
    1,
    'Recupera Vía Comunicación y actualiza Lead',
    'custom/modules/C5515_uni_chattigo/chattigo_origen.php',
    'Origen_Class',
    'Origen_Method'
);
