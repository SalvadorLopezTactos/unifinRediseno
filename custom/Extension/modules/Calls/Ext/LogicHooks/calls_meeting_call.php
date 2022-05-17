<?php
/**
 * Created by Salvador Lopez Balleza
 * salvador.lopez@tactos.com.mx
 * Date: 21/06/2019
 */

$hook_array['after_save'][] = Array(
    1,
    'Crea una nueva reunion o llamada ',
    'custom/modules/Calls/Call_Reunion_Llamada.php',
    'Call_Reunion_Llamada', // name of the class
    'SaveReunionLlamada' // name of the function
);