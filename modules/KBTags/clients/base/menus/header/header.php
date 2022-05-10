<?php
/* Created by SugarUpgrader for module KBTags */
$viewdefs['KBTags']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#KBTags/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'KBTags',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#KBTags',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'KBTags',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=KBTags',
    'label' => 'LNK_IMPORT_KBTAGS',
    'acl_action' => 'import',
    'acl_module' => 'KBTags',
    'icon' => 'icon-upload',
  ),
);
