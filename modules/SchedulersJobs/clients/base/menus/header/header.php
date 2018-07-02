<?php
/* Created by SugarUpgrader for module SchedulersJobs */
$viewdefs['SchedulersJobs']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#SchedulersJobs/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'SchedulersJobs',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#SchedulersJobs',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'SchedulersJobs',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=SchedulersJobs',
    'label' => 'LNK_IMPORT_SCHEDULERSJOBS',
    'acl_action' => 'import',
    'acl_module' => 'SchedulersJobs',
    'icon' => 'icon-upload',
  ),
);
