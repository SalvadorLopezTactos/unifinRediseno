<?php
// created: 2015-07-17 23:50:33
$viewdefs['RefBa_Referencia_Bancaria']['base']['view']['subpanel-for-accounts-refba_referencia_bancaria_accounts'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'institucion',
          'label' => 'LBL_INSTITUCION',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'numerocuenta_c',
          'label' => 'LBL_NUMEROCUENTA',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'fechaapertura',
          'label' => 'LBL_FECHAAPERTURA',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'saldo_promedio',
          'label' => 'LBL_SALDO_PROMEDIO',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
    'rowactions' => array(
        'actions' => array(
            array(
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'fa-eye',
                'acl_action' => 'view',
            ),
            array(
                'type' => 'rowaction',
                'name' => 'edit_button',
                'icon' => 'fa-pencil',
                'label' => 'LBL_EDIT_BUTTON',
                'event' => 'list:editrow:fire',
                'acl_action' => 'edit',
            ),
        ),
    ),
  'orderBy' => 
  array (
    'field' => 'date_modified',
    'direction' => 'desc',
  ),
  'type' => 'subpanel-list',
);