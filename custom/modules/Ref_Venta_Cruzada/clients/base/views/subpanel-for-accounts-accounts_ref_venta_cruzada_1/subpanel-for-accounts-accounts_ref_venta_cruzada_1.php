<?php
// created: 2020-07-23 17:50:52
$viewdefs['Ref_Venta_Cruzada']['base']['view']['subpanel-for-accounts-accounts_ref_venta_cruzada_1'] = array (
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
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'estatus',
          'label' => 'LBL_ESTATUS',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'numero_anexos',
          'label' => 'LBL_NUMERO_ANEXOS',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'ultima_fecha_anexo',
          'label' => 'LBL_ULTIMA_FECHA_ANEXO',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'motivo_rechazo',
          'label' => 'LBL_MOTIVO_RECHAZO',
          'enabled' => true,
          'default' => true,
        ),
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