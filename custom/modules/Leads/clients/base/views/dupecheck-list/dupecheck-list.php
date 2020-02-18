<?php

$viewdefs['Leads']['base']['view']['dupecheck-list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name_c',
                    'width' => 49,
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'tipo_registro_c',
                    'width' => 49,
                    'label' => 'LBL_TIPO_REGISTRO',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'subtipo_registro_c',
                    'width' => 49,
                    'label' => 'LBL_SUBTIPO_REGISTRO',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'regimen_fiscal_c',
                    'width' => 49,
                    'label' => 'LBL_REGIMEN_FISCAL',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => 49,
                    'label' => 'LBL_LIST_ASSIGNED_USER',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'date_entered',
                    'width' => 49,
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'default' => true,                    
                ),
            ),
        ),
    ),
);
