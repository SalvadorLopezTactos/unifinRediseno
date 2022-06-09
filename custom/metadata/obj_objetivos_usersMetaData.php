<?php
// created: 2022-06-03 21:25:28
$dictionary["obj_objetivos_users"] = array (
  'true_relationship_type' => 'one-to-one',
  'relationships' => 
  array (
    'obj_objetivos_users' => 
    array (
      'lhs_module' => 'Obj_Objetivos',
      'lhs_table' => 'obj_objetivos',
      'lhs_key' => 'id',
      'rhs_module' => 'Users',
      'rhs_table' => 'users',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'obj_objetivos_users_c',
      'join_key_lhs' => 'obj_objetivos_usersobj_objetivos_ida',
      'join_key_rhs' => 'obj_objetivos_usersusers_idb',
    ),
  ),
  'table' => 'obj_objetivos_users_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'obj_objetivos_usersobj_objetivos_ida' => 
    array (
      'name' => 'obj_objetivos_usersobj_objetivos_ida',
      'type' => 'id',
    ),
    'obj_objetivos_usersusers_idb' => 
    array (
      'name' => 'obj_objetivos_usersusers_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_obj_objetivos_users_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_obj_objetivos_users_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'obj_objetivos_usersobj_objetivos_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_obj_objetivos_users_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'obj_objetivos_usersusers_idb',
        1 => 'deleted',
      ),
    ),
  ),
);