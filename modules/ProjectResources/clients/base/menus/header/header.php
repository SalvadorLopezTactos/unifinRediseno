<?php
/* Created by SugarUpgrader for module ProjectResources */
$viewdefs['ProjectResources']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#ProjectResources/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'ProjectResources',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#ProjectResources',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'ProjectResources',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=ProjectResources',
    'label' => 'LNK_IMPORT_PROJECTRESOURCES',
    'acl_action' => 'import',
    'acl_module' => 'ProjectResources',
    'icon' => 'icon-upload',
  ),
);
