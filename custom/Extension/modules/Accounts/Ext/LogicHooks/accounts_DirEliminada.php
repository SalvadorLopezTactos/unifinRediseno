<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 20/03/2018
 */

/*
Definición de LH para procesar y actualizar direcciones, "eliminadas", asociadas a una Persona.
*/

/*
1.- Al guardar Persona;
*/
$hook_array['after_save'][] = Array(
    10,
    'Recupera direcciones eliminadas y envía actualización',
    'custom/modules/Accounts/lh_DirEliminadas.php',
    'DirEliminada_Class',
    'DirEliminada_Method'
);

