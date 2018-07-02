<?php
/* Created by SugarUpgrader for module Studio */
$viewdefs['Studio']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Studio/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Studio',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Studio',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Studio',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Studio',
    'label' => 'LNK_IMPORT_STUDIO',
    'acl_action' => 'import',
    'acl_module' => 'Studio',
    'icon' => 'icon-upload',
  ),
);
