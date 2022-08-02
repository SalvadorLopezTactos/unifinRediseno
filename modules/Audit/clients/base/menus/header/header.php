<?php
/* Created by SugarUpgrader for module Audit */
$viewdefs['Audit']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Audit/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Audit',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Audit',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Audit',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Audit',
    'label' => 'LNK_IMPORT_AUDIT',
    'acl_action' => 'import',
    'acl_module' => 'Audit',
    'icon' => 'icon-upload',
  ),
);
