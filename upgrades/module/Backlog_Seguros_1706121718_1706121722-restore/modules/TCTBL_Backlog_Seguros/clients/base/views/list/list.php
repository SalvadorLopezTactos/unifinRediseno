<?php
$module_name = 'TCTBL_Backlog_Seguros';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'mes',
                'label' => 'LBL_MES',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'anio',
                'label' => 'LBL_ANIO',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              3 => 
              array (
                'name' => 'etapa',
                'label' => 'LBL_ETAPA',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'tipo_operacion',
                'label' => 'LBL_TIPO_OPERACION',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'estimado_prima_neta_objetivo',
                'label' => 'LBL_ESTIMADO_PRIMA_NETA_OBJETIVO',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => false,
                'currency_format' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'estimado_prima_total_objetivo',
                'label' => 'LBL_ESTIMADO_PRIMA_TOTAL_OBJETIVO',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => false,
                'currency_format' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'no_backlog',
                'label' => 'LBL_NO_BACKLOG',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'producto',
                'label' => 'LBL_PRODUCTO',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'tipo_negocio',
                'label' => 'LBL_TIPO_NEGOCIO',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'tipo_poliza',
                'label' => 'LBL_TIPO_POLIZA',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'subramo',
                'label' => 'LBL_SUBRAMO',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'director_equipo',
                'label' => 'LBL_DIRECTOR_EQUIPO',
                'enabled' => true,
                'readonly' => false,
                'id' => 'USER_ID1_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'fecha_entrega_cliente',
                'label' => 'LBL_FECHA_ENTREGA_CLIENTE',
                'enabled' => true,
                'readonly' => false,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'referenciador',
                'label' => 'LBL_REFERENCIADOR',
                'enabled' => true,
                'readonly' => false,
                'id' => 'USER_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
