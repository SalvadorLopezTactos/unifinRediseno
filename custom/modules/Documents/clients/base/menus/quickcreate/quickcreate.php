<?php
// created: 2018-02-16 17:22:03
$viewdefs['Documents']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_DOCUMENT',
  'visible' => false,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'documents',
    ),
    1 => 
    array (
      'module' => 'Contacts',
      'link' => 'documents',
    ),
    2 => 
    array (
      'module' => 'Opportunities',
      'link' => 'documents',
    ),
    3 => 
    array (
      'module' => 'RevenueLineItems',
      'link' => 'documents',
    ),
  ),
);