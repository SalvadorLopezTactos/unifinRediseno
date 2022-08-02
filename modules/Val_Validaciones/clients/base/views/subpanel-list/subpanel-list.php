<?php
// created: 2015-09-22 16:59:39
$viewdefs['Val_Validaciones']['base']['view']['subpanel-list'] = array (
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
          'width' => '10%',
        ),
        1 => 
        array (
          'name' => 'modulo',
          'label' => 'LBL_MODULO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'campo_dependiente',
          'label' => 'LBL_CAMPO_DEPENDIENTE',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'campo_padre',
          'label' => 'LBL_CAMPO_PADRE',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'criterio_validacion',
          'label' => 'LBL_CRITERIO_VALIDACION',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'visible',
          'label' => 'LBL_VISIBLE',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'estatus',
          'label' => 'LBL_ESTATUS',
          'enabled' => true,
          'width' => '10%',
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
);