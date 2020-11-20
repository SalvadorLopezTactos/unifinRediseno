<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$dictionary['prod_Estructura_Productos'] = array(
    'table' => 'prod_estructura_productos',
    'audited' => true,
    'activity_enabled' => false,
    'duplicate_merge' => true,
    'fields' => array (
  'tipo_producto' => 
  array (
    'required' => false,
    'name' => 'tipo_producto',
    'vname' => 'LBL_TIPO_PRODUCTO',
    'type' => 'enum',
    'massupdate' => true,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'default' => '',
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'Institucion_list',
    'dependency' => false,
  ),
  'negocio' => 
  array (
    'required' => false,
    'name' => 'negocio',
    'vname' => 'LBL_NEGOCIO',
    'type' => 'enum',
    'massupdate' => true,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'default' => '',
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'Institucion_list',
    'dependency' => false,
  ),
  'producto_financiero' => 
  array (
    'required' => false,
    'name' => 'producto_financiero',
    'vname' => 'LBL_PRODUCTO_FINANCIERO',
    'type' => 'enum',
    'massupdate' => true,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'default' => '',
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'Institucion_list',
    'dependency' => false,
  ),
  'empresa' => 
  array (
    'required' => false,
    'name' => 'empresa',
    'vname' => 'LBL_EMPRESA',
    'type' => 'enum',
    'massupdate' => true,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'default' => '',
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'Institucion_list',
    'dependency' => false,
  ),
  'disponible_seleccion' => 
  array (
    'required' => false,
    'name' => 'disponible_seleccion',
    'vname' => 'LBL_DISPONIBLE_SELECCION',
    'type' => 'bool',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'default' => false,
    'calculated' => false,
    'size' => '20',
  ),
),
    'relationships' => array (
),
    'optimistic_locking' => true,
    'unified_search' => true,
    'full_text_search' => true,
);

if (!class_exists('VardefManager')){
}
VardefManager::createVardef('prod_Estructura_Productos','prod_Estructura_Productos', array('basic','team_security','assignable','taggable'));