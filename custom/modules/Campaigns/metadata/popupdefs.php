<?php
$popupMeta = array (
    'moduleMain' => 'Campaign',
    'varName' => 'CAMPAIGN',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'campaigns.name',
),
    'searchInputs' => array (
  0 => 'name',
),
    'searchdefs' => array (
  0 => 'name',
  1 => 'campaign_type',
  2 => 'status',
  3 => 'start_date',
  4 => 'end_date',
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_CAMPAIGN_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'STATUS' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_STATUS',
    'default' => true,
    'name' => 'status',
  ),
  'CAMPAIGN_TYPE' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_TYPE',
    'default' => true,
    'name' => 'campaign_type',
  ),
  'START_DATE' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_START_DATE',
    'default' => true,
    'name' => 'start_date',
  ),
  'END_DATE' => 
  array (
    'width' => 10,
    'label' => 'LBL_LIST_END_DATE',
    'default' => true,
    'name' => 'end_date',
  ),
),
);
