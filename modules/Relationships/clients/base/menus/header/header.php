<?php
/* Created by SugarUpgrader for module Relationships */
$viewdefs['Relationships']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Relationships/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Relationships',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Relationships',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Relationships',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Relationships',
    'label' => 'LNK_IMPORT_RELATIONSHIPS',
    'acl_action' => 'import',
    'acl_module' => 'Relationships',
    'icon' => 'icon-upload',
  ),
);
