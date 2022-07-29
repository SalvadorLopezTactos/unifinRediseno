<?php
/* Created by SugarUpgrader for module WorkFlowTriggerShells */
$viewdefs['WorkFlowTriggerShells']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#WorkFlowTriggerShells/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'WorkFlowTriggerShells',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#WorkFlowTriggerShells',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'WorkFlowTriggerShells',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=WorkFlowTriggerShells',
    'label' => 'LNK_IMPORT_WORKFLOWTRIGGERSHELLS',
    'acl_action' => 'import',
    'acl_module' => 'WorkFlowTriggerShells',
    'icon' => 'icon-upload',
  ),
);
