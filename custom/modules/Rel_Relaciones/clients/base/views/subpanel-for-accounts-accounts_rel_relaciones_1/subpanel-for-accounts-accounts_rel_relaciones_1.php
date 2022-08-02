<?php
// created: 2022-07-21 11:18:25
$viewdefs['Rel_Relaciones']['base']['view']['subpanel-for-accounts-accounts_rel_relaciones_1'] = array (
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
          'name' => 'relaciones_activas',
          'label' => 'LBL_RELACIONES_ACTIVAS',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'rel_relaciones_accounts_1_name',
          'label' => 'LBL_REL_RELACIONES_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
          'enabled' => true,
          'id' => 'REL_RELACIONES_ACCOUNTS_1ACCOUNTS_IDA',
          'link' => true,
          'sortable' => false,
          'default' => true,
        ),
        3 => 
        array (
          'label' => 'LBL_DATE_MODIFIED',
          'enabled' => true,
          'default' => true,
          'name' => 'date_modified',
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