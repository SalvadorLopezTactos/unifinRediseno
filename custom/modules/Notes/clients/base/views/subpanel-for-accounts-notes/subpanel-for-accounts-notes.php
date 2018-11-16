<?php
// created: 2018-11-16 14:23:22
$viewdefs['Notes']['base']['view']['subpanel-for-accounts-notes'] = array (
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
          'label' => 'LBL_LIST_SUBJECT',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'relacion_nota_minuta_c',
          'label' => 'LBL_RELACION_NOTA_MINUTA_C',
          'enabled' => true,
          'id' => 'MINUT_MINUTAS_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        2 => 
        array (
          'label' => 'LBL_LIST_DATE_ENTERED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_entered',
        ),
        3 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
  'type' => 'subpanel-list',
);