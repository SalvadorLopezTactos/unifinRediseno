<?php
/* Created by SugarUpgrader for module Trackers */
$viewdefs['Trackers']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#Trackers/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'Trackers',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#Trackers',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'Trackers',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=Trackers',
    'label' => 'LNK_IMPORT_TRACKERS',
    'acl_action' => 'import',
    'acl_module' => 'Trackers',
    'icon' => 'icon-upload',
  ),
);
