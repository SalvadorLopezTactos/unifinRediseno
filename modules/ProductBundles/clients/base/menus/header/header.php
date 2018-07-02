<?php
/* Created by SugarUpgrader for module ProductBundles */
$viewdefs['ProductBundles']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#ProductBundles/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'ProductBundles',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#ProductBundles',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'ProductBundles',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=ProductBundles',
    'label' => 'LNK_IMPORT_PRODUCTBUNDLES',
    'acl_action' => 'import',
    'acl_module' => 'ProductBundles',
    'icon' => 'icon-upload',
  ),
);
