<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 15/02/2018
 */

/*
Definición de LH para reasignar una llamada de una persona (Relación) a su Persona padre(Cliente)
*/

/*
1.- Al guardar Llamada;
*/
$hook_array['before_save'][] = Array(
    1,
    'Reasigna persona a llamada',
    'custom/modules/Calls/lh_reasigna_llamada.php',
    'reasigna_class',
    'reasigna_method'
);
