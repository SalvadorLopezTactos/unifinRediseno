<?php
$popupMeta = array (
    'moduleMain' => 'S_seguros',
    'varName' => 'S_seguros',
    'orderBy' => 's_seguros.name',
    'whereClauses' => array (
  'name' => 's_seguros.name',
  'etapa' => 's_seguros.etapa',
  'assigned_user_id' => 's_seguros.assigned_user_id',
  'favorites_only' => 's_seguros.favorites_only',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'etapa',
  5 => 'assigned_user_id',
  6 => 'favorites_only',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => 10,
  ),
  'etapa' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_ETAPA',
    'width' => 10,
    'name' => 'etapa',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => 10,
  ),
  'favorites_only' => 
  array (
    'name' => 'favorites_only',
    'label' => 'LBL_FAVORITES_FILTER',
    'type' => 'bool',
    'width' => 10,
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'ETAPA' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_ETAPA',
    'width' => 10,
  ),
  'TEAM_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_TEAM',
    'default' => true,
    'name' => 'team_name',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'name' => 'assigned_user_name',
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
