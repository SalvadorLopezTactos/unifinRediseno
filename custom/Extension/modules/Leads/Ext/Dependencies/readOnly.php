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
    ),
);
