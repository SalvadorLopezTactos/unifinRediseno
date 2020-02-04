<?php

/*******************APELLIDO MATERNO*****************/
$dependencies['Leads']['apellido_materno_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'apellido_materno_c',
                'label'  => 'apellido_materno_c_label', 
                'value'  => 'and(or(equal($subtipo_registro_c, "2"),equal($subtipo_registro_c, "4")),not(equal($regimen_fiscal_c,"Persona Moral")))',  //SUB-TIPO LEAD ES CONTACTADO, CONVERTIDO Y QUE NO SEA PERSONA MORAL
            ),
        ),
    ),
);

/*******************MACROSECTOR*****************/
$dependencies['Leads']['macrosector_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'macrosector_c',
                'label'  => 'macrosector_c_label', 
                'value'  => 'equal($subtipo_registro_c, "2")',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

/*******************VENTAS ANUALES*****************/
$dependencies['Leads']['ventas_anuales_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'ventas_anuales_c',
                'label'  => 'ventas_anuales_c_label', 
                'value'  => 'equal($subtipo_registro_c, "2")',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

/*******************POTENCIAL DE LEAD*****************/
$dependencies['Leads']['potencial_lead_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'potencial_lead_c',
                'label'  => 'potencial_lead_c_label', 
                'value'  => 'equal($subtipo_registro_c, "2")',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

/*******************ZONA GEOGRAFICA*****************/
$dependencies['Leads']['zona_geografica_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'zona_geografica_c',
                'label'  => 'zona_geografica_c_label', 
                'value'  => 'equal($subtipo_registro_c, "2")',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

/*******************EMAIL*****************/
$dependencies['Leads']['email'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'email',
                'label'  => 'email_label', 
                'value'  => 'equal($subtipo_registro_c, "2")',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

/*******************PUESTO*****************/
$dependencies['Leads']['puesto_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired', //Action type
            'params' => array(
                'target' => 'puesto_c',
                'label'  => 'puesto_c_label', 
                'value'  => 'and(equal($subtipo_registro_c, "2"),not(equal($regimen_fiscal_c, "Persona Moral")))',  //SUB-TIPO LEAD ES CONTACTADO
            ),
        ),
    ),
);

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