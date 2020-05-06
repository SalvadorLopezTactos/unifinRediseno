<?php

/*$dependencies['Leads']['setoptions_regimen_fiscal'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('regimen_fiscal_c','id'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetOptions',
            'params' => array(
                'target' => 'regimen_fiscal_c',
                'keys' => 'ifElse(not(equal($id,"")),ifElse(equal($regimen_fiscal_c,"3"),createList("3"),createList("1","2")),getDropdownKeySet("regimen_fiscal_list"))',
                'labels' => 'ifElse(not(equal($id,"")),ifElse(equal($regimen_fiscal_c,"3"),createList("3"),createList("1","2")),getDropdownValueSet("regimen_fiscal_list"))',
            ),
        ),
    ),
);*/

// 'ifElse(equal($ayuda_asesor_cp_c,"1"),createList("Exitoso","No exitoso","En proceso"),getDropdownValueSet("task_status_dom"))'

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
                'value'  => 'and(equal($origen_c, "2"),equal($detalle_origen_c, "10"))',
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