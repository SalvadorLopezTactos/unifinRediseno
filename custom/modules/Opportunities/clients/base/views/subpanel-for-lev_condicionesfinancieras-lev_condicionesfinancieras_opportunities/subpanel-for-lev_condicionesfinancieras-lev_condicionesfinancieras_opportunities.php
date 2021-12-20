<?php
// created: 2018-02-16 20:36:01
$viewdefs['Opportunities']['base']['view']['subpanel-for-accounts-opportunities'] = array (
  'type' => 'subpanel-list',
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
        'allow_bwc' => false,
      ),
      1 => 
      array (
        'type' => 'unlink-action',
        'icon' => 'icon-unlink',
        'label' => 'LBL_UNLINK_BUTTON',
      ),
    ),
  ),
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
          'label' => 'LBL_LIST_OPPORTUNITY_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'estatus_c',
          'label' => 'LBL_ESTATUS',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'monto_c',
          'label' => 'LBL_MONTO',
          'enabled' => true,
          'related_fields' => 
          array (
            0 => 'currency_id',
            1 => 'base_rate',
          ),
          'currency_format' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'amount',
          'label' => 'LBL_LIKELY',
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
        4 => 
        array (
          'name' => 'vigencialinea_c',
          'label' => 'LBL_VIGENCIALINEA',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'fecha_estimada_cierre_c',
          'label' => 'LBL_FECHA_ESTIMADA_CIERRE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
);