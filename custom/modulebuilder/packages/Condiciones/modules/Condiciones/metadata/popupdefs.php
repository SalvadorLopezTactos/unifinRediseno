<?php
$popupMeta = array (
    'moduleMain' => 'tct4_Condiciones',
    'varName' => 'tct4_Condiciones',
    'orderBy' => 'tct4_condiciones.name',
    'whereClauses' => array (
  'condicion' => 'tct4_condiciones.condicion',
  'razon' => 'tct4_condiciones.razon',
  'motivo' => 'tct4_condiciones.motivo',
  'detalle' => 'tct4_condiciones.detalle',
  'bloquea' => 'tct4_condiciones.bloquea',
  'notifica' => 'tct4_condiciones.notifica',
  'responsable1' => 'tct4_condiciones.responsable1',
  'responsable2' => 'tct4_condiciones.responsable2',
),
    'searchInputs' => array (
  4 => 'condicion',
  5 => 'razon',
  6 => 'motivo',
  7 => 'detalle',
  8 => 'bloquea',
  9 => 'notifica',
  10 => 'responsable1',
  11 => 'responsable2',
),
    'searchdefs' => array (
  'condicion' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_CONDICION',
    'width' => '10',
    'name' => 'condicion',
  ),
  'razon' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_RAZON',
    'width' => '10',
    'name' => 'razon',
  ),
  'motivo' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_MOTIVO',
    'width' => '10',
    'name' => 'motivo',
  ),
  'detalle' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_DETALLE',
    'width' => '10',
    'name' => 'detalle',
  ),
  'bloquea' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_BLOQUEA',
    'width' => '10',
    'name' => 'bloquea',
  ),
  'notifica' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_NOTIFICA',
    'width' => '10',
    'name' => 'notifica',
  ),
  'responsable1' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_RESPONSABLE1',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => '10',
    'name' => 'responsable1',
  ),
  'responsable2' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_RESPONSABLE2',
    'id' => 'USER_ID1_C',
    'link' => true,
    'width' => '10',
    'name' => 'responsable2',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'label' => 'LBL_NAME',
    'width' => 10,
    'default' => true,
  ),
  'CONDICION' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_CONDICION',
    'width' => 10,
  ),
  'RAZON' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_RAZON',
    'width' => 10,
  ),
  'MOTIVO' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_MOTIVO',
    'width' => 10,
  ),
  'DETALLE' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_DETALLE',
    'width' => 10,
  ),
  'BLOQUEA' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_BLOQUEA',
    'width' => 10,
  ),
  'NOTIFICA' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_NOTIFICA',
    'width' => 10,
  ),
  'RESPONSABLE1' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_RESPONSABLE1',
    'id' => 'USER_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
  ),
  'RESPONSABLE2' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_RESPONSABLE2',
    'id' => 'USER_ID1_C',
    'link' => true,
    'width' => 10,
    'default' => true,
  ),
  'TEAM_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'portallistview' => false,
      'portalrecordview' => false,
    ),
    'label' => 'LBL_TEAMS',
    'id' => 'TEAM_ID',
    'width' => 10,
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'link' => true,
    'type' => 'relate',
    'related_fields' => 
    array (
      0 => 'assigned_user_id',
    ),
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => 10,
    'default' => true,
  ),
  'DATE_MODIFIED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_MODIFIED',
    'width' => 10,
    'default' => true,
  ),
),
);
