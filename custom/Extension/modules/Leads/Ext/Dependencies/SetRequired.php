<?php

/*******************AGENTE ASIGNADO*****************/
$dependencies['Leads']['assigned_user_name'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'assigned_user_name',
                'label'  => 'assigned_user_name_label', 
                'value'  => 'equal($subtipo_registro_c, "2")',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

/*******************PROMOTOR-¿QUE ASESOR?*****************/
$dependencies['Leads']['promotor_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('origen_c','detalle_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'promotor_c',
                'label'  => 'promotor_c_label', 
                'value'  => 'and(equal($origen_c, "2"),equal($detalle_origen_c, "Cartera Promotores"))',
            ),
        ),
    ),
);

/*******************MOTIVO DE CANCELACION*****************/
$dependencies['Leads']['motivo_cancelacion_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'motivo_cancelacion_c',
                'label'  => 'motivo_cancelacion_c_label', 
                'value'  => 'equal($subtipo_registro_c, "3")',  //SUB-TIPO LEAD ES CANCELADO
            ),
        ),
    ),
);