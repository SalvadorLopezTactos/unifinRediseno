<?php
// created: 2022-04-22 12:45:02
$dictionary["QPRO_Encuestas"]["fields"]["qpro_gestion_encuestas_qpro_encuestas"] = array (
  'name' => 'qpro_gestion_encuestas_qpro_encuestas',
  'type' => 'link',
  'relationship' => 'qpro_gestion_encuestas_qpro_encuestas',
  'source' => 'non-db',
  'module' => 'QPRO_Gestion_Encuestas',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_QPRO_GESTION_ENCUESTAS_QPRO_ENCUESTAS_FROM_QPRO_ENCUESTAS_TITLE',
  'id_name' => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
  'link-type' => 'one',
);
$dictionary["QPRO_Encuestas"]["fields"]["qpro_gestion_encuestas_qpro_encuestas_name"] = array (
  'name' => 'qpro_gestion_encuestas_qpro_encuestas_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_QPRO_GESTION_ENCUESTAS_QPRO_ENCUESTAS_FROM_QPRO_GESTION_ENCUESTAS_TITLE',
  'save' => true,
  'id_name' => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
  'link' => 'qpro_gestion_encuestas_qpro_encuestas',
  'table' => 'qpro_gestion_encuestas',
  'module' => 'QPRO_Gestion_Encuestas',
  'rname' => 'name',
);
$dictionary["QPRO_Encuestas"]["fields"]["qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida"] = array (
  'name' => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_QPRO_GESTION_ENCUESTAS_QPRO_ENCUESTAS_FROM_QPRO_ENCUESTAS_TITLE_ID',
  'id_name' => 'qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida',
  'link' => 'qpro_gestion_encuestas_qpro_encuestas',
  'table' => 'qpro_gestion_encuestas',
  'module' => 'QPRO_Gestion_Encuestas',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
