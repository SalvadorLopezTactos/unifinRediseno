<?php
/* Created by SugarUpgrader for module HealthCheck */
$viewdefs['HealthCheck']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#HealthCheck/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'HealthCheck',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#HealthCheck',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'HealthCheck',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=HealthCheck',
    'label' => 'LNK_IMPORT_HEALTHCHECK',
    'acl_action' => 'import',
    'acl_module' => 'HealthCheck',
    'icon' => 'icon-upload',
  ),
);
