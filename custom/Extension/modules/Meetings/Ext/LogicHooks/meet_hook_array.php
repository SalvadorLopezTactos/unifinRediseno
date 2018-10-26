<?php
    /**
     * Created by CVV
     * User: carmen.velasco@unifin.com.mx
     * Date: 19/10/2016
     */

$hook_array['after_save'][] = Array(
    1,
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

$hook_array['before_save'][] = Array(
    1,
    'Send email to related people',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'Getmails' // name of the function
);

//Adrian Arauz
$hook_array['after_save'][] = Array(
    2,
    'Apply Meeting/Objectives into Minuta',
    'custom/modules/Meetings/meetings_hooks.php',
    'Meetings_Hooks', // name of the class
    'saveObjetivos' // name of the function
);
