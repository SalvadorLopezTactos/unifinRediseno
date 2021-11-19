<?php
/* Created by SugarUpgrader for module Expressions */
$viewdefs['Expressions']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Expressions/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Expressions',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Expressions',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Expressions',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Expressions',
    'label' => 'LNK_IMPORT_EXPRESSIONS',
    'acl_action' => 'import',
    'acl_module' => 'Expressions',
    'icon' => 'icon-upload',
  ),
);
