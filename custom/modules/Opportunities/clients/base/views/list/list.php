<?php
// created: 2024-05-21 12:55:59
$viewdefs['Opportunities']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'link' => true,
          'label' => 'LBL_LIST_OPPORTUNITY_NAME',
          'enabled' => true,
          'default' => true,
          'related_fields' => 
          array (
            0 => 'total_revenue_line_items',
            1 => 'closed_revenue_line_items',
          ),
        ),
        1 => 
        array (
          'name' => 'account_name',
          'link' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'tct_estapa_subetapa_txf_c',
          'label' => 'LBL_TCT_ESTAPA_SUBETAPA_TXF',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_LIST_ASSIGNED_USER',
          'id' => 'ASSIGNED_USER_ID',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'tipo_producto_c',
          'label' => 'LBL_TIPO_PRODUCTO',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'negocio_c',
          'label' => 'LBL_NEGOCIO_C',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'producto_financiero_c',
          'label' => 'LBL_PRODUCTO_FINANCIERO_C',
          'enabled' => true,
          'default' => true,
        ),
        7 => 
        array (
          'name' => 'team_name',
          'type' => 'teamset',
          'label' => 'LBL_LIST_TEAM',
          'enabled' => true,
          'default' => false,
        ),
        8 => 
        array (
          'name' => 'forecasted_likely',
          'comment' => 'Rollup of included RLIs on the Opportunity',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_FORECASTED_LIKELY',
          'span' => 6,
        ),
        9 => 
        array (
          'name' => 'lost',
          'comment' => 'Rollup of lost RLIs on the Opportunity',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'label' => 'LBL_LOST',
        ),
      ),
    ),
  ),
);