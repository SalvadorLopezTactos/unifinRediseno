<?php
$module_name = 'dire_Direccion';
$viewdefs[$module_name] =
    array (
        'mobile' =>
            array (
                'view' =>
                    array (
                        'detail' =>
                            array (
                                'templateMeta' =>
                                    array (
                                        'maxColumns' => '1',
                                        'widths' =>
                                            array (
                                                0 =>
                                                    array (
                                                        'label' => '10',
                                                        'field' => '30',
                                                    ),
                                                1 =>
                                                    array (
                                                        'label' => '10',
                                                        'field' => '30',
                                                    ),
                                            ),
                                        'useTabs' => false,
                                    ),
                                'panels' =>
                                    array (
                                        0 =>
                                            array (
                                                'label' => 'LBL_PANEL_DEFAULT',
                                                'newTab' => false,
                                                'panelDefault' => 'expanded',
                                                'name' => 'LBL_PANEL_DEFAULT',
                                                'columns' => '1',
                                                'labelsOnTop' => 1,
                                                'placeholders' => 1,
                                                'fields' =>
                                                    array (
                                                        0 =>
                                                            array (
                                                                'name' => 'tipodedireccion',
                                                                'studio' => 'visible',
                                                                'label' => 'LBL_TIPODEDIRECCION',
                                                            ),
                                                        1 =>
                                                            array (
                                                                'name' => 'indicador',
                                                                'studio' => 'visible',
                                                                'label' => 'LBL_INDICADOR',
                                                            ),
                                                        2 =>
                                                            array (
                                                                'name' => 'dire_direccion_dire_pais_name',
                                                                'label' => 'LBL_DIRE_DIRECCION_DIRE_PAIS_FROM_DIRE_PAIS_TITLE',
                                                            ),
                                                        3 =>
                                                            array (
                                                                'name' => 'dire_direccion_dire_estado_name',
                                                                'label' => 'LBL_DIRE_DIRECCION_DIRE_ESTADO_FROM_DIRE_ESTADO_TITLE',
                                                            ),
                                                        4 =>
                                                            array (
                                                                'name' => 'dire_direccion_dire_municipio_name',
                                                                'label' => 'LBL_DIRE_DIRECCION_DIRE_MUNICIPIO_FROM_DIRE_MUNICIPIO_TITLE',
                                                            ),
                                                        5 =>
                                                            array (
                                                                'name' => 'dire_direccion_dire_codigopostal_name',
                                                                'label' => 'LBL_DIRE_DIRECCION_DIRE_CODIGOPOSTAL_FROM_DIRE_CODIGOPOSTAL_TITLE',
                                                            ),
                                                        6 =>
                                                            array (
                                                                'name' => 'dire_direccion_dire_ciudad_name',
                                                                'label' => 'LBL_DIRE_DIRECCION_DIRE_CIUDAD_FROM_DIRE_CIUDAD_TITLE',
                                                            ),
                                                        7 =>
                                                            array (
                                                                'name' => 'dire_direccion_dire_colonia_name',
                                                                'label' => 'LBL_DIRE_DIRECCION_DIRE_COLONIA_FROM_DIRE_COLONIA_TITLE',
                                                            ),
                                                        8 =>
                                                            array (
                                                                'name' => 'calle',
                                                                'label' => 'LBL_CALLE',
                                                            ),
                                                        9 =>
                                                            array (
                                                                'name' => 'principal',
                                                                'label' => 'LBL_PRINCIPAL',
                                                            ),
                                                        10 =>
                                                            array (
                                                                'name' => 'numext',
                                                                'label' => 'LBL_NUMEXT',
                                                            ),
                                                        11 =>
                                                            array (
                                                                'name' => 'numint',
                                                                'label' => 'LBL_NUMINT',
                                                            ),
                                                    ),
                                            ),
                                    ),
                            ),
                    ),
            ),
    );
