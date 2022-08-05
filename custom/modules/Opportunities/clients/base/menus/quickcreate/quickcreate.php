<?php
// created: 2018-02-16 17:22:03
$viewdefs['Opportunities']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_OPPORTUNITY',
  'visible' => true,
  'order' => 1,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'opportunities',
    ),
    1 => 
    array (
      'module' => 'Contacts',
      'link' => 'opportunities',
    ),
  ),
);