<?php
// created: 2015-06-08 19:39:07
$dictionary["emp_empleo"]["fields"]["emp_empleo_accounts"] = array (
  'name' => 'emp_empleo_accounts',
  'type' => 'link',
  'relationship' => 'emp_empleo_accounts',
  'source' => 'non-db',
  'module' => 'Accounts',
  'bean_name' => 'Account',
  'side' => 'right',
  'vname' => 'LBL_EMP_EMPLEO_ACCOUNTS_FROM_EMP_EMPLEO_TITLE',
  'id_name' => 'emp_empleo_accountsaccounts_ida',
  'link-type' => 'one',
);
$dictionary["emp_empleo"]["fields"]["emp_empleo_accounts_name"] = array (
  'name' => 'emp_empleo_accounts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_EMP_EMPLEO_ACCOUNTS_FROM_ACCOUNTS_TITLE',
  'save' => true,
  'id_name' => 'emp_empleo_accountsaccounts_ida',
  'link' => 'emp_empleo_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'name',
);
$dictionary["emp_empleo"]["fields"]["emp_empleo_accountsaccounts_ida"] = array (
  'name' => 'emp_empleo_accountsaccounts_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_EMP_EMPLEO_ACCOUNTS_FROM_EMP_EMPLEO_TITLE_ID',
  'id_name' => 'emp_empleo_accountsaccounts_ida',
  'link' => 'emp_empleo_accounts',
  'table' => 'accounts',
  'module' => 'Accounts',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
