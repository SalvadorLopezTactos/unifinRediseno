<?php
/* Created by SugarUpgrader for module UserPreferences */
$viewdefs['UserPreferences']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#UserPreferences/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'UserPreferences',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#UserPreferences',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'UserPreferences',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=UserPreferences',
    'label' => 'LNK_IMPORT_USERPREFERENCES',
    'acl_action' => 'import',
    'acl_module' => 'UserPreferences',
    'icon' => 'icon-upload',
  ),
);
