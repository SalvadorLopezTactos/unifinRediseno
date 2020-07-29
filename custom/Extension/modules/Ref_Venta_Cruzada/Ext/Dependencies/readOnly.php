<?php
global $current_user;
$puesto = $current_user->puestousuario_c;

//Dependencia Edición
$dependencies['Ref_Venta_Cruzada']['estatus'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'estatus',
                'value' => 'true',
            ),
        ),
    ),
    'notActions' => array(),
);
$dependencies['Ref_Venta_Cruzada']['assigned_user_name'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'assigned_user_name',
                'value' => 'true',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Ref_Venta_Cruzada']['cancelado_Visibility'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'cancelado',
                'value' => 'isInList('.$puesto.',createList("2","8","14","21"))',
            ),
        ),
    ),
);
