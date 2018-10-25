<?php
/**
 * @author F. Javier G. Solar
 * Date: 25/10/2018
 * Time: 11:50 AM
 *
 */

$hook_array['after_save'][] = Array(
    3,
    'Crea Relacion entre Minuta y Participantes',
    'custom/modules/minut_Minutas/minutMinutas_Hooks.php',
    'minutMinutas_Hooks',
    'createParticipantes'
);