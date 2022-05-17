<?php
 /**
 * @file   opp_hook_array.php
 * @author Adrián_Arauz
 * @date   4/3/2021 11:31 AM
 * @brief  opportunity logic hook array
 */


$hook_array['after_save'][] = Array(
    16,
    'Envío de Notificaciones a Asesores RM (Cuenta/Opps) ',
    'custom/modules/Opportunities/opp_notificacion_director.php',
    'NotificacionDirector', // name of the class
    'notificaParticipacionRM'
);