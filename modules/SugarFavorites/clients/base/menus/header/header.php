<?php
/* Created by SugarUpgrader for module SugarFavorites */
$viewdefs['SugarFavorites']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#SugarFavorites/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'SugarFavorites',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#SugarFavorites',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'SugarFavorites',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=SugarFavorites',
    'label' => 'LNK_IMPORT_SUGARFAVORITES',
    'acl_action' => 'import',
    'acl_module' => 'SugarFavorites',
    'icon' => 'icon-upload',
  ),
);
