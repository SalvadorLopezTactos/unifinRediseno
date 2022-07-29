<?php
/* Created by SugarUpgrader for module EAPM */
$viewdefs['EAPM']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#EAPM/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'EAPM',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#EAPM',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'EAPM',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=EAPM',
    'label' => 'LNK_IMPORT_EAPM',
    'acl_action' => 'import',
    'acl_module' => 'EAPM',
    'icon' => 'icon-upload',
  ),
);
