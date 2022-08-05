<?php
$popupMeta = array (
    'moduleMain' => 'Val_Validaciones',
    'varName' => 'Val_Validaciones',
    'orderBy' => 'val_validaciones.name',
    'whereClauses' => array (
  'name' => 'val_validaciones.name',
  'modulo' => 'val_validaciones.modulo',
  'campo_padre' => 'val_validaciones.campo_padre',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'modulo',
  5 => 'campo_padre',
),
    'searchdefs' => array (
  'modulo' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_MODULO',
    'width' => '10%',
    'name' => 'modulo',
  ),
  'campo_padre' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CAMPO_PADRE',
    'width' => '10%',
    'name' => 'campo_padre',
  ),
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
    'name' => 'name',
  ),
  'MODULO' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_MODULO',
    'width' => '10%',
    'default' => true,
    'name' => 'modulo',
  ),
  'CAMPO_PADRE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CAMPO_PADRE',
    'width' => '10%',
    'default' => true,
    'name' => 'campo_padre',
  ),
  'CAMPO_DEPENDIENTE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CAMPO_DEPENDIENTE',
    'width' => '10%',
    'default' => true,
    'name' => 'campo_dependiente',
  ),
),
);
