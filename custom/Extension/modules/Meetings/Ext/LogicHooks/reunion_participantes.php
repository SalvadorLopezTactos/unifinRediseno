<?php
/**
 * @author Tactos
 * Date: 06/06/2022
 */

$hook_array['after_save'][] = Array(
    7,
    'Crea Relación entre Reunión y Participantes',
    'custom/modules/Meetings/reunion_participantes.php',
    'reunion_participantes_class',
    'reunion_participantes'
);
