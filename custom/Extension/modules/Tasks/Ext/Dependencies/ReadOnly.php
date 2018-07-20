<?php
global $current_user;
$userid=$current_user->id;

//Dependencia para ocultar en Tareas la cuenta y así asignar una única a la relación Adrian Arauz 20/707/18
$dependencies['Tasks']['TareasNo'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
//Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('parent_name','id'),
    'onload' => true,
//Actions is a list of actions to fire when the trigger is true
// You could list multiple fields here each in their own array under 'actions'
    'actions' => array(
        array(
            'name' => 'ReadOnly',
//The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'parent_name',
                'value' => 'true',
            ),
        ),

    ),
);