<?php
/* Created by SugarUpgrader for module ProductBundleNotes */
$viewdefs['ProductBundleNotes']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#ProductBundleNotes/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'ProductBundleNotes',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#ProductBundleNotes',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'ProductBundleNotes',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=ProductBundleNotes',
    'label' => 'LNK_IMPORT_PRODUCTBUNDLENOTES',
    'acl_action' => 'import',
    'acl_module' => 'ProductBundleNotes',
    'icon' => 'icon-upload',
  ),
);
