<?php
$viewdefs['Accounts'] = 
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
                'name' => 'tct_prioridad_ddw_c',
                'label' => 'LBL_TCT_PRIORIDAD_DDW',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'link' => true,
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'enabled' => true,
                'default' => true,
                'width' => 'xlarge',
              ),
              2 => 
              array (
                'name' => 'tct_tipo_subtipo_txf_c',
                'label' => 'LBL_TCT_TIPO_SUBTIPO_TXF',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'promotorleasing_c',
                'label' => 'LBL_PROMOTORLEASING',
                'enabled' => true,
                'id' => 'USER_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'promotorfactoraje_c',
                'label' => 'LBL_PROMOTORFACTORAJE',
                'enabled' => true,
                'id' => 'USER_ID1_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'promotorcredit_c',
                'label' => 'LBL_PROMOTORCREDIT',
                'enabled' => true,
                'id' => 'USER_ID2_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'promotorfleet_c',
                'label' => 'LBL_PROMOTORFLEET',
                'enabled' => true,
                'id' => 'USER_ID6_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'subtipo_cuenta_c',
                'label' => 'LBL_SUBTIPO_CUENTA',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'tipo_registro_c',
                'label' => 'LBL_TIPO_REGISTRO',
                'enabled' => true,
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
