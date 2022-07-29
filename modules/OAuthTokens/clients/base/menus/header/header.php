<?php
/* Created by SugarUpgrader for module OAuthTokens */
$viewdefs['OAuthTokens']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#OAuthTokens/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'OAuthTokens',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#OAuthTokens',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'OAuthTokens',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=OAuthTokens',
    'label' => 'LNK_IMPORT_OAUTHTOKENS',
    'acl_action' => 'import',
    'acl_module' => 'OAuthTokens',
    'icon' => 'icon-upload',
  ),
);
