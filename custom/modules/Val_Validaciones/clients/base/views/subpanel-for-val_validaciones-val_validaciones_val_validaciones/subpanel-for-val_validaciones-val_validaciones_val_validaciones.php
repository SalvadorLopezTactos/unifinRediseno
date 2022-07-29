<?php
// created: 2015-09-24 17:37:28
$viewdefs['Val_Validaciones']['base']['view']['subpanel-for-val_validaciones-val_validaciones_val_validaciones'] = array (
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
          'name' => 'modulo',
          'label' => 'LBL_MODULO',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'campo_dependiente',
          'label' => 'LBL_CAMPO_DEPENDIENTE',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'campo_padre',
          'label' => 'LBL_CAMPO_PADRE',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'criterio_validacion',
          'label' => 'LBL_CRITERIO_VALIDACION',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'visible',
          'label' => 'LBL_VISIBLE',
          'enabled' => true,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'requerido',
          'label' => 'LBL_REQUERIDO',
          'enabled' => true,
          'default' => true,
        ),
        7 => 
        array (
          'name' => 'estatus',
          'label' => 'LBL_ESTATUS',
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