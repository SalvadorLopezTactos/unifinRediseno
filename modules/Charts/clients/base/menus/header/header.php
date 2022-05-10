<?php
/* Created by SugarUpgrader for module Charts */
$viewdefs['Charts']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Charts/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Charts',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Charts',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Charts',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Charts',
    'label' => 'LNK_IMPORT_CHARTS',
    'acl_action' => 'import',
    'acl_module' => 'Charts',
    'icon' => 'icon-upload',
  ),
);
