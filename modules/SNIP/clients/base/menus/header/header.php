<?php
/* Created by SugarUpgrader for module SNIP */
$viewdefs['SNIP']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#SNIP/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'SNIP',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#SNIP',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'SNIP',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=SNIP',
    'label' => 'LNK_IMPORT_SNIP',
    'acl_action' => 'import',
    'acl_module' => 'SNIP',
    'icon' => 'icon-upload',
  ),
);
