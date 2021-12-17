<?php
/* Created by SugarUpgrader for module ModuleBuilder */
$viewdefs['ModuleBuilder']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#ModuleBuilder/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'ModuleBuilder',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#ModuleBuilder',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'ModuleBuilder',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=ModuleBuilder',
    'label' => 'LNK_IMPORT_MODULEBUILDER',
    'acl_action' => 'import',
    'acl_module' => 'ModuleBuilder',
    'icon' => 'icon-upload',
  ),
);
