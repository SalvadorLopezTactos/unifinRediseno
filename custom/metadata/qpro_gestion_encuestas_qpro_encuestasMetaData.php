<?php
// created: 2022-04-22 12:44:59
$dictionary["qpro_gestion_encuestas_qpro_encuestas"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'qpro_gestion_encuestas_qpro_encuestas' => 
    array (
      'lhs_module' => 'QPRO_Gestion_Encuestas',
      'lhs_table' => 'qpro_gestion_encuestas',
      'lhs_key' => 'id',
      'rhs_module' => 'QPRO_Encuestas',
      'rhs_table' => 'qpro_encuestas',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'qpro_gestion_encuestas_qpro_encuestas_c',
      'join_key_lhs' => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
      'join_key_rhs' => 'qpro_gestion_encuestas_qpro_encuestasqpro_encuestas_idb',
    ),
  ),
  'table' => 'qpro_gestion_encuestas_qpro_encuestas_c',
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
    'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida' => 
    array (
      'name' => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
      'type' => 'id',
    ),
    'qpro_gestion_encuestas_qpro_encuestasqpro_encuestas_idb' => 
    array (
      'name' => 'qpro_gestion_encuestas_qpro_encuestasqpro_encuestas_idb',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_qpro_gestion_encuestas_qpro_encuestas_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_qpro_gestion_encuestas_qpro_encuestas_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_qpro_gestion_encuestas_qpro_encuestas_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'qpro_gestion_encuestas_qpro_encuestasqpro_encuestas_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'qpro_gestion_encuestas_qpro_encuestas_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'qpro_gestion_encuestas_qpro_encuestasqpro_encuestas_idb',
      ),
    ),
  ),
);