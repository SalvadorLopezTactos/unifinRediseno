<?php
global $current_user;
$puesto = $current_user->puestousuario_c;
$id = $current_user->id;
$permiso=$current_user->tct_cancelar_ref_cruzada_chk_c;
$prooducto=$current_user->tipodeproducto_c;
//$GLOBALS['log']->fatal("EL PERMISO: ".$permiso);
//$GLOBALS['log']->fatal("PRODUCTO: ".$producto);

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
    'triggerFields' => array('id'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'usuario_producto',
                'value' => 'not(equal($id,""))',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Ref_Venta_Cruzada']['usuario_rm'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'usuario_rm',
                'value' => 'not(equal($id,""))',
            ),
        ),
    ),
    'notActions' => array(),
);

$dependencies['Ref_Venta_Cruzada']['accounts_ref_venta_cruzada_1_name'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'accounts_ref_venta_cruzada_1_name',
                'value' => 'not(equal($id,""))',
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

/*
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
                'value' => 'ifElse(and(isInList('.$permiso.',createList("1")),equal($producto_referenciado, '.$producto.'),equal($estatus,"1")),"1","0")',
            ),
        ),
    ),
);
*/
