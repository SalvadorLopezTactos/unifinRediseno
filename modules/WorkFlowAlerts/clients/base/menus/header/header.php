<?php
/* Created by SugarUpgrader for module WorkFlowAlerts */
$viewdefs['WorkFlowAlerts']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#WorkFlowAlerts/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'WorkFlowAlerts',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#WorkFlowAlerts',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'WorkFlowAlerts',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=WorkFlowAlerts',
    'label' => 'LNK_IMPORT_WORKFLOWALERTS',
    'acl_action' => 'import',
    'acl_module' => 'WorkFlowAlerts',
    'icon' => 'icon-upload',
  ),
);
