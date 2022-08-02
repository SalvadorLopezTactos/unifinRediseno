<?php
// created: 2018-05-03 13:50:53
$dictionary["Account"]["fields"]["users_accounts_1"] = array (
  'name' => 'users_accounts_1',
  'type' => 'link',
  'relationship' => 'users_accounts_1',
  'source' => 'non-db',
  'module' => 'Employees',
  'bean_name' => 'User',
  'side' => 'right',
  'vname' => 'LBL_USERS_ACCOUNTS_1_FROM_ACCOUNTS_TITLE',
  'id_name' => 'users_accounts_1users_ida',
  'link-type' => 'one',
);
$dictionary["Account"]["fields"]["users_accounts_1_name"] = array (
  'name' => 'users_accounts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_ACCOUNTS_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_accounts_1users_ida',
  'link' => 'users_accounts_1',
  'table' => 'users',
  'module' => 'Employees',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Account"]["fields"]["users_accounts_1users_ida"] = array (
  'name' => 'users_accounts_1users_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_ACCOUNTS_1_FROM_ACCOUNTS_TITLE_ID',
  'id_name' => 'users_accounts_1users_ida',
  'link' => 'users_accounts_1',
  'table' => 'users',
  'module' => 'Employees',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
