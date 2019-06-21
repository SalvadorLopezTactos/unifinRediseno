<?php
/**
 * Created by Adrian Arauz.
 * User: root
 * Date: 7/01/19
 * Time: 10:55 AM
 */

$hook_array['after_save'][] = Array(
    12,
    'Impide eliminar grupo global de nuevos usuarios',
    'custom/modules/Users/DefaultTeam.php',
    'DefaultTeam',
    'gpoGlobal'
);

$hook_array['after_save'][] = Array(
    13,
    'Valida y agrega team_sets con equipo privado y equipo principal unics',
    'custom/modules/Users/DefaultTeam.php',
    'DefaultTeam',
    'create_team_sets'
);
