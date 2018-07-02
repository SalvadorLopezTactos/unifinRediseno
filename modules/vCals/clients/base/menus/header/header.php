<?php
/* Created by SugarUpgrader for module vCals */
$viewdefs['vCals']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#vCals/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'vCals',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#vCals',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'vCals',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=vCals',
    'label' => 'LNK_IMPORT_VCALS',
    'acl_action' => 'import',
    'acl_module' => 'vCals',
    'icon' => 'icon-upload',
  ),
);
