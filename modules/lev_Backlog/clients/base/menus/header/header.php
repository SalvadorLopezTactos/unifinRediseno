<?php

/* This file was generated by the 7_FixIconNameChanges upgrader */
$viewdefs['lev_Backlog']['base']['menu']['header'] =  array (
  0 => 
  array (
    'route' => '#lev_Backlog/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'lev_Backlog',
    'icon' => 'fa-plus',
  ),
  1 => 
  array (
    'route' => '#lev_Backlog',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'lev_Backlog',
    'icon' => 'fa-bars',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=lev_Backlog&return_module=lev_Backlog&return_action=index',
    'label' => 'LBL_IMPORT',
    'acl_action' => 'import',
    'acl_module' => 'lev_Backlog',
    'icon' => 'fa-upload',
  ),
);
