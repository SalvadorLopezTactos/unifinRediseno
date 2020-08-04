<?php
global $current_user;
$puesto = $current_user->puestousuario_c;
$id = $current_user->id;

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

$dependencies['Ref_Venta_Cruzada']['usuario_producto'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'usuario_producto',
                'value' => 'true',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Ref_Venta_Cruzada']['usuario_rm'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'usuario_rm',
                'value' => 'true',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Ref_Venta_Cruzada']['accounts_ref_venta_cruzada_1_name'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'accounts_ref_venta_cruzada_1_name',
                'value' => 'true',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Ref_Venta_Cruzada']['producto_origen'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'producto_origen',
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
    'triggerFields' => array('description'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'cancelado',
                'value' => 'ifElse(and(isInList('.$puesto.',createList("2","8","14","20","21")),greaterThan(strlen($description),0)),"1","0")',
            ),
        ),
    ),
);
