<?php
/* Created by SugarUpgrader for module MySettings */
$viewdefs['MySettings']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#MySettings/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'MySettings',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#MySettings',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'MySettings',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=MySettings',
    'label' => 'LNK_IMPORT_MYSETTINGS',
    'acl_action' => 'import',
    'acl_module' => 'MySettings',
    'icon' => 'icon-upload',
  ),
);
