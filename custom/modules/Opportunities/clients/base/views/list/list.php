<?php
$viewdefs['Opportunities'] = 
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
                'name' => 'team_name',
                'type' => 'teamset',
                'label' => 'LBL_LIST_TEAM',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
