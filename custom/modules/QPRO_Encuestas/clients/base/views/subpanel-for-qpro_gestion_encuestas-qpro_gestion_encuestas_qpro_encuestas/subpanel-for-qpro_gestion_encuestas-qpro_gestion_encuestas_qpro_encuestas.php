<?php
// created: 2022-05-13 11:28:29
$viewdefs['QPRO_Encuestas']['base']['view']['subpanel-for-qpro_gestion_encuestas-qpro_gestion_encuestas_qpro_encuestas'] = array (
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
          'name' => 'related_module',
          'label' => 'LBL_RELATED_MODULE',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'cuenta',
          'label' => 'LBL_CUENTA',
          'enabled' => true,
          'readonly' => false,
          'id' => 'ACCOUNT_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'lead',
          'label' => 'LBL_LEAD',
          'enabled' => true,
          'readonly' => false,
          'id' => 'LEAD_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'usuario',
          'label' => 'LBL_USUARIO',
          'enabled' => true,
          'readonly' => false,
          'id' => 'USER_ID_C',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'fecha_envio',
          'label' => 'LBL_FECHA_ENVIO',
          'enabled' => true,
          'readonly' => false,
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'fecha_respuesta',
          'label' => 'LBL_FECHA_RESPUESTA',
          'enabled' => true,
          'readonly' => false,
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