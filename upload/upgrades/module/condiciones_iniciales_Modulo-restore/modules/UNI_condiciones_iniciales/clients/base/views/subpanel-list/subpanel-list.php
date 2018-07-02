<?php
// created: 2016-03-29 16:49:31
$viewdefs['UNI_condiciones_iniciales']['base']['view']['subpanel-list'] = array (
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
          'name' => 'activo',
          'label' => 'LBL_ACTIVO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'campo_destino_minimo',
          'label' => 'LBL_CAMPO_DESTINO_MINIMO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'rango_minimo',
          'label' => 'LBL_RANGO_MINIMO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'campo_destino_maximo',
          'label' => 'LBL_CAMPO_DESTINO_MAXIMO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'rango_maximo',
          'label' => 'LBL_RANGO_MAXIMO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        6 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
          'width' => '10%',
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