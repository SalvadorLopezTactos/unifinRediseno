<?php
// created: 2018-10-29 11:47:03
$viewdefs['minut_Participantes']['base']['view']['subpanel-for-minut_minutas-minut_minutas_minut_participantes'] = array (
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
          'name' => 'tct_nombre_completo_c',
          'label' => 'LBL_TCT_NOMBRE_COMPLETO_C',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'tct_apellido_paterno_c',
          'label' => 'LBL_TCT_APELLIDO_PATERNO_C',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'tct_apellido_materno_c',
          'label' => 'LBL_TCT_APELLIDO_MATERNO_C',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'tct_asistencia_c',
          'label' => 'LBL_TCT_ASISTENCIA_C',
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