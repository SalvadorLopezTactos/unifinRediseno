<?php
/* Created by SugarUpgrader for module EmailAddresses */
$viewdefs['EmailAddresses']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#EmailAddresses/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'EmailAddresses',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#EmailAddresses',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'EmailAddresses',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=EmailAddresses',
    'label' => 'LNK_IMPORT_EMAILADDRESSES',
    'acl_action' => 'import',
    'acl_module' => 'EmailAddresses',
    'icon' => 'icon-upload',
  ),
);
