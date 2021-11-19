<?php
/* Created by SugarUpgrader for module KBDocumentRevisions */
$viewdefs['KBDocumentRevisions']['base']['menu']['header'] =array (
  0 => 
  array (
    'route' => '#KBDocumentRevisions/create',
    'label' => 'LNK_NEW_RECORD',
    'acl_action' => 'create',
    'acl_module' => 'KBDocumentRevisions',
    'icon' => 'icon-plus',
  ),
  1 => 
  array (
    'route' => '#KBDocumentRevisions',
    'label' => 'LNK_LIST',
    'acl_action' => 'list',
    'acl_module' => 'KBDocumentRevisions',
    'icon' => 'icon-reorder',
  ),
  2 => 
  array (
    'route' => '#bwc/index.php?module=Import&action=Step1&import_module=KBDocumentRevisions',
    'label' => 'LNK_IMPORT_KBDOCUMENTREVISIONS',
    'acl_action' => 'import',
    'acl_module' => 'KBDocumentRevisions',
    'icon' => 'icon-upload',
  ),
);
