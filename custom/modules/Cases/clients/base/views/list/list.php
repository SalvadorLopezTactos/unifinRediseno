<?php
// created: 2024-05-21 12:55:59
$viewdefs['Cases']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'case_number',
          'label' => 'LBL_LIST_NUMBER',
          'link' => true,
          'default' => true,
          'enabled' => true,
          'readonly' => true,
        ),
        1 => 
        array (
          'name' => 'name',
          'label' => 'LBL_LIST_SUBJECT',
          'default' => true,
          'enabled' => true,
        ),
        2 => 
        array (
          'name' => 'status',
          'label' => 'LBL_STATUS',
          'default' => true,
          'enabled' => true,
        ),
        3 => 
        array (
          'name' => 'priority',
          'label' => 'LBL_LIST_PRIORITY',
          'default' => true,
          'enabled' => true,
        ),
        4 => 
        array (
          'name' => 'producto_c',
          'label' => 'LBL_PRODUCTO',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'codigo_producto_c',
          'label' => 'LBL_CODIGO_PRODUCTO',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'type',
          'label' => 'LBL_TYPE',
          'enabled' => true,
          'default' => true,
        ),
        7 => 
        array (
          'name' => 'subtipo_c',
          'label' => 'LBL_SUBTIPO',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        8 => 
        array (
          'name' => 'account_name',
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'module' => 'Accounts',
          'id' => 'ACCOUNT_ID',
          'ACLTag' => 'ACCOUNT',
          'related_fields' => 
          array (
            0 => 'account_id',
          ),
          'link' => true,
          'default' => true,
          'enabled' => true,
        ),
        9 => 
        array (
          'name' => 'contacto_principal_c',
          'label' => 'LBL_CONTACTO_PRINCIPAL',
          'enabled' => true,
          'readonly' => false,
          'id' => 'ACCOUNT_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        10 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
          'id' => 'ASSIGNED_USER_ID',
          'default' => true,
          'enabled' => true,
        ),
        11 => 
        array (
          'name' => 'follow_up_datetime',
          'label' => 'LBL_FOLLOW_UP',
          'default' => true,
          'enabled' => true,
        ),
        12 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'default' => true,
          'enabled' => true,
          'readonly' => true,
        ),
        13 => 
        array (
          'name' => 'date_modified',
          'enabled' => true,
          'default' => true,
        ),
        14 => 
        array (
          'name' => 'source',
          'label' => 'LBL_SOURCE',
          'enabled' => true,
          'default' => false,
        ),
        15 => 
        array (
          'name' => 'service_level',
          'label' => 'LBL_SERVICE_LEVEL',
          'default' => false,
          'enabled' => true,
          'readonly' => true,
        ),
        16 => 
        array (
          'name' => 'detalle_subtipo_c',
          'label' => 'LBL_DETALLE_SUBTIPO',
          'enabled' => true,
          'readonly' => false,
          'default' => false,
        ),
        17 => 
        array (
          'name' => 'resolution',
          'label' => 'LBL_RESOLUTION',
          'enabled' => true,
          'sortable' => false,
          'default' => false,
        ),
        18 => 
        array (
          'name' => 'vip_c',
          'label' => 'LBL_VIP',
          'enabled' => true,
          'readonly' => false,
          'default' => false,
        ),
        19 => 
        array (
          'name' => 'team_name',
          'label' => 'LBL_LIST_TEAM',
          'default' => false,
          'enabled' => true,
        ),
      ),
    ),
  ),
);