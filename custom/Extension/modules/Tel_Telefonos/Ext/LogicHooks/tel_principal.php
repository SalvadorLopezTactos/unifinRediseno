<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 09/03/2018
 */

/*
Definición de LH para actualizar teléfono principal en Persona relacionada(teléfono de oficina)
*/

/*
1.- Al guardar Teléfono;
*/
$hook_array['before_save'][] = Array(
    4,
    'Actualiza teléfono marcado como principal en Persona asociada',
    'custom/modules/Tel_Telefonos/lh_tel_principal.php', //path to the logic hook
    'principal_class', // name of the class
    'principal_method' // name of the function.

);
