<?php
$popupMeta = array (
    'moduleMain' => 'Lead',
    'varName' => 'LEAD',
    'orderBy' => 'last_name, first_name',
    'whereClauses' => array (
  'lead_source' => 'leads.lead_source',
  'status' => 'leads.status',
  'account_name' => 'leads.account_name',
  'assigned_user_id' => 'leads.assigned_user_id',
  'name' => 'leads.name',
  'name_c' => 'leads_cstm.name_c',
  'email' => 'leads.email',
  'regimen_fiscal_c' => 'leads_cstm.regimen_fiscal_c',
  'tipo_registro_c' => 'leads_cstm.tipo_registro_c',
  'subtipo_registro_c' => 'leads_cstm.subtipo_registro_c',
  'nombre_de_cargar_c' => 'leads_cstm.nombre_de_cargar_c',
  'assigned_user_name' => 'leads.assigned_user_name',
  'contacto_asociado_c' => 'leads_cstm.contacto_asociado_c',
),
    'searchInputs' => array (
  2 => 'lead_source',
  3 => 'status',
  4 => 'account_name',
  5 => 'assigned_user_id',
  6 => 'name',
  7 => 'name_c',
  8 => 'email',
  9 => 'regimen_fiscal_c',
  10 => 'tipo_registro_c',
  11 => 'subtipo_registro_c',
  12 => 'nombre_de_cargar_c',
  13 => 'assigned_user_name',
  14 => 'contacto_asociado_c',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'fullname',
    'label' => 'LBL_NAME',
    'width' => '10',
    'name' => 'name',
  ),
  'name_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NAME',
    'width' => '10',
    'name' => 'name_c',
  ),
  'tipo_registro_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TIPO_REGISTRO',
    'width' => '10',
    'name' => 'tipo_registro_c',
  ),
  'subtipo_registro_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_SUBTIPO_REGISTRO',
    'width' => '10',
    'name' => 'subtipo_registro_c',
  ),
  'regimen_fiscal_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_REGIMEN_FISCAL',
    'width' => '10',
    'name' => 'regimen_fiscal_c',
  ),
  'email' => 
  array (
    'name' => 'email',
    'width' => '10',
  ),
  'account_name' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ACCOUNT_NAME',
    'width' => '10',
    'name' => 'account_name',
  ),
  'lead_source' => 
  array (
    'name' => 'lead_source',
    'width' => '10',
  ),
  'status' => 
  array (
    'name' => 'status',
    'width' => '10',
  ),
  'nombre_de_cargar_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NOMBRE_DE_CARGAR',
    'width' => '10',
    'name' => 'nombre_de_cargar_c',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'related_fields' => 
    array (
      0 => 'assigned_user_id',
    ),
    'label' => 'LBL_ASSIGNED_TO',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10',
    'name' => 'assigned_user_name',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'type' => 'enum',
    'label' => 'LBL_ASSIGNED_TO',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10',
  ),
  'contacto_asociado_c' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_CONTACTO_ASOCIADO_C',
    'width' => 10,
    'name' => 'contacto_asociado_c',
  ),
),
    'listviewdefs' => array (
  'NAME_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NAME',
    'width' => 10,
    'default' => true,
    'name' => 'name_c',
  ),
  'TIPO_REGISTRO_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_TIPO_REGISTRO',
    'width' => 10,
    'name' => 'tipo_registro_c',
  ),
  'SUBTIPO_REGISTRO_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_SUBTIPO_REGISTRO',
    'width' => 10,
    'name' => 'subtipo_registro_c',
  ),
  'REGIMEN_FISCAL_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_REGIMEN_FISCAL',
    'width' => 10,
    'name' => 'regimen_fiscal_c',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
    'name' => 'date_entered',
  ),
  'NOMBRE_DE_CARGAR_C' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_NOMBRE_DE_CARGAR',
    'width' => 10,
    'default' => true,
    'name' => 'nombre_de_cargar_c',
  ),
  'CONTACTO_ASOCIADO_C' => 
  array (
    'type' => 'bool',
    'default' => true,
    'label' => 'LBL_CONTACTO_ASOCIADO_C',
    'width' => 10,
  ),
),
);
