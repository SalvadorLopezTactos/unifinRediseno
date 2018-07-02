<?php
/* Created by SugarUpgrader for module KBContents */
$viewdefs['KBContents']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#KBContents/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'KBContents',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#KBContents',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'KBContents',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=KBContents',
    'label' => 'LNK_IMPORT_KBCONTENTS',
    'acl_action' => 'import',
    'acl_module' => 'KBContents',
    'icon' => 'icon-upload',
  ),
);
