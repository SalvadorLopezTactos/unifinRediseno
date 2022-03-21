<?php

$dependencies['Leads']['readonly_fields'] = array(
    'hooks' => array('edit', 'view'),
    'trigger' => 'true',
    'triggerFields' => array('lead_cancelado_c', 'subtipo_registro_c', 'origen_ag_tel_c', 'promotor_c','detalle_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'origen_ag_tel_c',
                'value' => 'or(equal($detalle_origen_c,"2"),equal($detalle_origen_c,"8"),equal($detalle_origen_c,"6"),equal($detalle_origen_c,"5"),equal($detalle_origen_c,"4"),equal($detalle_origen_c,"3"),equal($detalle_origen_c,"9"),equal($detalle_origen_c,"1"),equal($detalle_origen_c,"10"))',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'origen_ag_tel_c',
                'value' => 'or(and(equal($lead_cancelado_c,"1"),equal($subtipo_registro_c,"3")),equal($subtipo_registro_c,"4"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'promotor_c',
                'value' => 'equal($detalle_origen_c,"10")',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'promotor_c',
                'value' => 'or(and(equal($lead_cancelado_c,"1"),equal($subtipo_registro_c,"3")),equal($subtipo_registro_c,"4"))',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'assigned_user_name',
                'value' => 'or(and(equal($lead_cancelado_c,"1"),equal($subtipo_registro_c,"3")),equal($subtipo_registro_c,"4"))',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'email',
                'value' => 'or(and(equal($lead_cancelado_c,"1"),equal($subtipo_registro_c,"3")),equal($subtipo_registro_c,"4"))',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'id_landing_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'lead_source_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'facebook_pixel_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'ga_client_id_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'keyword_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'campana_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'compania_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'producto_financiero_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'nombre_de_cargar_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'pb_division_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'pb_grupo_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'pb_clase_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'macrosector_c',
                'value' => 'not(equal($pb_clase_c,""))',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'subsector_c',
                'value' => 'not(equal($pb_clase_c,""))',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'productos_interes_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'opportunity_amount',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'plazo_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'pago_mensual_estimado_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'medios_contacto_deseado_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'medio_preferido_contacto_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'dia_contacto_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'hora_contacto_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'metodo_asignacion_lm_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'c_registro_reus_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'm_registro_reus_c',
                'value' => 'true',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'o_registro_reus_c',
                'value' => 'true',
            ),
        ),
    ),
);

/*
$dependencies['Leads']['origen_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'origen_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['detalle_origen_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'detalle_origen_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['medio_digital_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'medio_digital_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['evento_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'evento_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['origen_busqueda_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'origen_busqueda_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['camara_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'camara_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['promotor_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'promotor_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['prospeccion_propia_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'prospeccion_propia_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
$dependencies['Leads']['punto_contacto_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','fecha_bloqueo_origen_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly', //Action type
            'params' => array(
                'target' => 'punto_contacto_c',
                'value'  => 'or(equal(daysUntil($fecha_bloqueo_origen_c),0),greaterThan(daysUntil($fecha_bloqueo_origen_c),0))',
            ),
        ),
    ),
);
*/