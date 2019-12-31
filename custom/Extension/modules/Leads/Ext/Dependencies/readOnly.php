<?php

$dependencies['Leads']['readonly_fields'] = array
(
    'hooks' => array('edit','view'),
    'trigger' => 'true',
    'triggerFields' => array('subtipo_registro_c','origen_c','detalle_origen_c','medio_digital_c','regimen_fiscal_c'),
    'onload' => true,
    'actions' => array
    (
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'tipo_registro_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'tipo_subtipo_registro_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'regimen_fiscal_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'origen_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'detalle_origen_c',
                'value' => 'or(equal($origen_c,"1"),equal($origen_c,"2"))',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'detalle_origen_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'medio_digital_c',
                'value' => 'or(equal($detalle_origen_c,"Digital"),equal($detalle_origen_c,"Offline")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'medio_digital_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'punto_contacto_c',
                'value' => '$medio_digital_c',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'punto_contacto_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'evento_c',
                'value' => 'equal($detalle_origen_c,"Acciones Estrategicas")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'evento_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'origen_busqueda_c',
                'value' => 'equal($detalle_origen_c,"Bases de datos")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'origen_busqueda_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'camara_c',
                'value' => 'equal($detalle_origen_c,"Afiliaciones")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'camara_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'promotor_c',
                'value' => 'equal($detalle_origen_c,"Cartera Promotores")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'promotor_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'origen_ag_tel_c',
                'value' => 'or(equal($detalle_origen_c,"Centro de Prospeccion"),equal($detalle_origen_c,"Parques Industriales"),equal($detalle_origen_c,"Afiliaciones"),equal($detalle_origen_c,"Acciones Estrategicas"),equal($detalle_origen_c,"Campanas"),equal($detalle_origen_c,"Digital"),equal($detalle_origen_c,"Offline"),equal($detalle_origen_c,"Bases de datos"),equal($detalle_origen_c,"Cartera Promotores"))',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'origen_ag_tel_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'nombre_empresa_c',
                'value' => 'equal($regimen_fiscal_c,"Persona Moral")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'nombre_empresa_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'nombre_c',
                'value' => 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'nombre_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'apellido_materno_c',
                'value' => 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'apellido_materno_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'apellido_paterno_c',
                'value' => 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'apellido_paterno_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'macrosector_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'ventas_anuales_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'potencial_lead_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'zona_geografica_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'puesto_c',
                'value' => 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'puesto_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'lead_asociado_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'motivo_cancelacion_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        // array
        // (
        //     'name' => 'ReadOnly',
        //     'params' => array
        //     (
        //         'target' => 'motivo_cancelacion_c',
        //         'value' => 'equal($subtipo_registro_c,"3")',
        //     ),
        // ),
        array
        (
            'name' => 'SetVisibility',
            'params' => array
            (
                'target' => 'submotivo_cancelacion_c',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        // array
        // (
        //     'name' => 'ReadOnly',
        //     'params' => array
        //     (
        //         'target' => 'submotivo_cancelacion_c',
        //         'value' => 'equal($subtipo_registro_c,"3")',
        //     ),
        // ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'email',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'phone_mobile',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'phone_home',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'phone_work',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'assigned_user_name',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
        array
        (
            'name' => 'ReadOnly',
            'params' => array
            (
                'target' => 'leads_leads_1_name',
                'value' => 'equal($subtipo_registro_c,"3")',
            ),
        ),
    ),
);
