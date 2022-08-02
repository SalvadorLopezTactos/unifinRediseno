<?php
$popupMeta = array (
    'moduleMain' => 'Opportunity',
    'varName' => 'OPPORTUNITY',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'opportunities.name',
  'account_name' => 'accounts.name',
  'opportunity_type' => 'opportunities.opportunity_type',
  'sales_stage' => 'opportunities.sales_stage',
  'tct_etapa_ddw_c' => 'opportunities_cstm.tct_etapa_ddw_c',
  'estatus_c' => 'opportunities_cstm.estatus_c',
  'assigned_user_id' => 'opportunities.assigned_user_id',
),
    'searchInputs' => array (
  0 => 'name',
  1 => 'account_name',
  2 => 'opportunity_type',
  3 => 'sales_stage',
  4 => 'tct_etapa_ddw_c',
  5 => 'estatus_c',
  6 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => 10,
  ),
  'account_name' => 
  array (
    'name' => 'account_name',
    'displayParams' => 
    array (
      'hideButtons' => 'true',
      'size' => 30,
      'class' => 'sqsEnabled sqsNoAutofill',
    ),
    'width' => 10,
  ),
  'opportunity_type' => 
  array (
    'name' => 'opportunity_type',
    'width' => 10,
  ),
  'sales_stage' => 
  array (
    'name' => 'sales_stage',
    'width' => 10,
  ),
  'tct_etapa_ddw_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TCT_ETAPA_DDW_C',
    'width' => 10,
    'name' => 'tct_etapa_ddw_c',
  ),
  'estatus_c' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_ESTATUS',
    'width' => 10,
    'name' => 'estatus_c',
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
    'width' => 10,
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_OPPORTUNITY_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'id' => 'ACCOUNT_ID',
    'module' => 'Accounts',
    'default' => true,
    'sortable' => true,
    'ACLTag' => 'ACCOUNT',
    'name' => 'account_name',
  ),
  'SALES_STATUS' => 
  array (
    'type' => 'enum',
    'readonly' => false,
    'studio' => true,
    'default' => true,
    'label' => 'LBL_SALES_STATUS',
    'width' => 10,
  ),
  'AMOUNT' => 
  array (
    'type' => 'currency',
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'readonly' => false,
    'label' => 'LBL_LIKELY',
    'currency_format' => true,
    'width' => 10,
    'default' => true,
  ),
  'TCT_ETAPA_DDW_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_TCT_ETAPA_DDW_C',
    'width' => 10,
  ),
  'ESTATUS_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_ESTATUS',
    'width' => 10,
  ),
),
);
