<?php
/* Created by SugarUpgrader for module History */
$viewdefs['History']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#History/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'History',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#History',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'History',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=History',
    'label' => 'LNK_IMPORT_HISTORY',
    'acl_action' => 'import',
    'acl_module' => 'History',
    'icon' => 'icon-upload',
  ),
);
