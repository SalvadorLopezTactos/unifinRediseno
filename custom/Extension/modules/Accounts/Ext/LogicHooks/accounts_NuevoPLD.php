<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 20/03/2018
 */

/*
Agrega PLD
*/

/*
1.- Al guardar Persona;
*/
$hook_array['after_save'][] = Array(
    13,
    'Guarda registros de nuevos PLD',
    'custom/modules/Accounts/lh_NuevoPLD.php',
    'NuevoPLD_Class',
    'NuevoPLD_Method'
);
