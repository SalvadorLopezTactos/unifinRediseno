<?php
$module_name = 'tct4_Condiciones';
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
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'condicion',
                'label' => 'LBL_CONDICION',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'razon',
                'label' => 'LBL_RAZON',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'motivo',
                'label' => 'LBL_MOTIVO',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'detalle',
                'label' => 'LBL_DETALLE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'bloquea',
                'label' => 'LBL_BLOQUEA',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'notifica',
                'label' => 'LBL_NOTIFICA',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'responsable1',
                'label' => 'LBL_RESPONSABLE1',
                'enabled' => true,
                'id' => 'USER_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'responsable2',
                'label' => 'LBL_RESPONSABLE2',
                'enabled' => true,
                'id' => 'USER_ID1_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              10 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              11 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              12 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
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
