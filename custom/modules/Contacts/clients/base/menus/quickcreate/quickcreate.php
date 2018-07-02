<?php
// created: 2018-02-16 17:22:03
$viewdefs['Contacts']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_CONTACT',
  'visible' => false,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'contacts',
    ),
    1 => 
    array (
      'module' => 'Opportunities',
      'link' => 'contacts',
    ),
  ),
);