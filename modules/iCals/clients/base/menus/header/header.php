<?php
/* Created by SugarUpgrader for module iCals */
$viewdefs['iCals']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#iCals/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'iCals',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#iCals',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'iCals',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=iCals',
    'label' => 'LNK_IMPORT_ICALS',
    'acl_action' => 'import',
    'acl_module' => 'iCals',
    'icon' => 'icon-upload',
  ),
);
