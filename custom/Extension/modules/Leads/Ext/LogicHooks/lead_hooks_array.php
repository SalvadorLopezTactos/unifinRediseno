<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/16/2015
 * Time: 4:24 PM
 */
$hook_array['after_save'][] = Array(
    1,
    'crear Persona prospecto',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'crearProspecto'
);


$hook_array['after_save'][] = Array(
    3,
    'crear URL de Originación',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    'crearURLOriginacion'
);

$hook_array['after_save'][] = Array(
    4,
    'Convierte a Cuenta',
    'custom/modules/Leads/Lead_Hooks.php',
    'Lead_Hooks',
    're_asign_meetings'
);

$hook_array['after_save'][] = Array(
    5,
    'Direcciones_Leads_Hooks',//Just a quick comment about the logic of it
    'custom/modules/Leads/lead_direcciones_class.php', //path to the logic hook
    'lead_direcciones_class', // name of the class
    'lead_direcciones_function' // name of the function.
);

$hook_array['after_save'][] = Array(
    6,
    'Enviar notificaciones a Vendors',//Just a quick comment about the logic of it
    'custom/modules/Leads/NotificacionVendor.php', //path to the logic hook
    'NotificacionVendor', // name of the class
    'notificaVendors' // name of the function.
);
