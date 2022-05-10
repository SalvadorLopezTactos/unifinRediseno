<?php
/* Created by SugarUpgrader for module KBDocumentKBTags */
$viewdefs['KBDocumentKBTags']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#KBDocumentKBTags/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'KBDocumentKBTags',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#KBDocumentKBTags',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'KBDocumentKBTags',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=KBDocumentKBTags',
    'label' => 'LNK_IMPORT_KBDOCUMENTKBTAGS',
    'acl_action' => 'import',
    'acl_module' => 'KBDocumentKBTags',
    'icon' => 'icon-upload',
  ),
);
