<?php
/* Created by SugarUpgrader for module Versions */
$viewdefs['Versions']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Versions/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Versions',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Versions',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Versions',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Versions',
    'label' => 'LNK_IMPORT_VERSIONS',
    'acl_action' => 'import',
    'acl_module' => 'Versions',
    'icon' => 'icon-upload',
  ),
);
