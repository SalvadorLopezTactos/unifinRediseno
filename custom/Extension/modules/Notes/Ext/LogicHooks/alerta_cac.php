<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 28/03/2018
 */

/*
Definición de LH para generar alerta cuando una nota es creada por usuario CAC
*/

/*
1.- Al guardar Nota;
*/
$hook_array['before_save'][] = Array(
    2,
    'Generación de alerta al guardar nota por usuario CAC',
    'custom/modules/Notes/lh_alerta_cac.php',
    'alerta_cac_Class',
    'alerta_cac_Method'
);

