<?php
/* Created by SugarUpgrader for module WorkFlowAlertShells */
$viewdefs['WorkFlowAlertShells']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#WorkFlowAlertShells/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'WorkFlowAlertShells',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#WorkFlowAlertShells',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'WorkFlowAlertShells',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=WorkFlowAlertShells',
    'label' => 'LNK_IMPORT_WORKFLOWALERTSHELLS',
    'acl_action' => 'import',
    'acl_module' => 'WorkFlowAlertShells',
    'icon' => 'icon-upload',
  ),
);
