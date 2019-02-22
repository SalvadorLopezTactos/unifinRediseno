<?php
    /**
     * Created by CVV
     * User: carmen.velasco@unifin.com.mx
     * Date: 19/10/2016
     */

$hook_array['after_save'][] = Array(
    2,
    'Create a new Meeting for companion',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'MeetingAcompaniante' // name of the function
);

$hook_array['after_relationship_add'][] = Array(
    1,
    'Create a new Meeting for companion',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'RelationAdd' // name of the function
);

$hook_array['after_relationship_delete'][] = Array(
    1,
    'Create a new Meeting for companion',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'RelationDel' // name of the function
);


//@Jesus Carrillo

/* $hook_array['before_save'][] = Array(
    1,
    'Send email to related people',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'Getmails' // name of the function
); */

//Adrian Arauz
$hook_array['after_save'][] = Array(
    3,
    'Apply Meeting/Objectives into Minuta',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'saveObjetivos' // name of the function
);

$hook_array['before_save'][] = Array(
    1,
    'Cambia LevAdmin',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'cambiAdmin' // name of the function
);

$hook_array['after_save'][] = Array(
    4,
    'Cambia LevAdmin',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'cambiAdmin2' // name of the function
);

$hook_array['after_save'][]=Array(
    1,
    'No se agrega a centro de prospección',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', //name of the class
    'modificaReunion' //name of the fuction
);
//LH para insertar valores a tabla custom de meetings_audit, la cual se creó pegándole directo a la base de datos
$hook_array['before_save'][] = Array(
    2,
    'Insertar registros a tabla de auditoría meetings_audit',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'insertAuditFields' // name of the function
);
$hook_array['after_save'][]=Array(
    5,
    'Elimina a los invitados de la primera reunion',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks',
    'EliminaInvitados'
);