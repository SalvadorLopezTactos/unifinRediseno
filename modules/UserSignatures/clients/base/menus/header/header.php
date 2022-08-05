<?php
/* Created by SugarUpgrader for module UserSignatures */
$viewdefs['UserSignatures']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#UserSignatures/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'UserSignatures',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#UserSignatures',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'UserSignatures',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=UserSignatures',
    'label' => 'LNK_IMPORT_USERSIGNATURES',
    'acl_action' => 'import',
    'acl_module' => 'UserSignatures',
    'icon' => 'icon-upload',
  ),
);
