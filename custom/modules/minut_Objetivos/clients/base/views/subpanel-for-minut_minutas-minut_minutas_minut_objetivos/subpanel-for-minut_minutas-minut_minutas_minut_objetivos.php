<?php
// created: 2018-10-29 11:47:24
$viewdefs['minut_Objetivos']['base']['view']['subpanel-for-minut_minutas-minut_minutas_minut_objetivos'] = array (
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
          'label' => 'LBL_NAME',
          'enabled' => true,
          'link' => true,
          'default' => true,
        ),
        1 => 
        array (
          'name' => 'tct_objetivo_c',
          'label' => 'LBL_TCT_OBJETIVO_C',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'tct_cumplimiento_chk',
          'label' => 'LBL_TCT_CUMPLIMIENTO_CHK',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'date_entered',
          'label' => 'LBL_DATE_ENTERED',
          'enabled' => true,
          'readonly' => true,
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