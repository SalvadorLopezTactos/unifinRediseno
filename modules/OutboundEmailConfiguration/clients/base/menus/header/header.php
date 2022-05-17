<?php
/* Created by SugarUpgrader for module OutboundEmailConfiguration */
$viewdefs['OutboundEmailConfiguration']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#OutboundEmailConfiguration/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'OutboundEmailConfiguration',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#OutboundEmailConfiguration',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'OutboundEmailConfiguration',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=OutboundEmailConfiguration',
    'label' => 'LNK_IMPORT_OUTBOUNDEMAILCONFIGURATION',
    'acl_action' => 'import',
    'acl_module' => 'OutboundEmailConfiguration',
    'icon' => 'icon-upload',
  ),
);
