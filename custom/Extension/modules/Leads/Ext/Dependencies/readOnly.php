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
                'value' => 'or(equal($detalle_origen_c,"Centro de Prospeccion"),equal($detalle_origen_c,"Parques Industriales"),equal($detalle_origen_c,"Afiliaciones"),equal($detalle_origen_c,"Acciones Estrategicas"),equal($detalle_origen_c,"Campanas"),equal($detalle_origen_c,"Digital"),equal($detalle_origen_c,"Offline"),equal($detalle_origen_c,"Bases de datos"),equal($detalle_origen_c,"Cartera Promotores"))',
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
                'value' => 'equal($detalle_origen_c,"Cartera Promotores")',
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
    ),
);
