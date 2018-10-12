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
$vardefs = array (
  'fields' => 
  array (
    'tct_compromiso_c' => 
    array (
      'required' => false,
      'name' => 'tct_compromiso_c',
      'vname' => 'LBL_TCT_COMPROMISO_C',
      'type' => 'varchar',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '1',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'default' => '',
      'full_text_search' => 
      array (
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
      ),
      'calculated' => false,
      'len' => '255',
      'size' => '20',
    ),
    'tct_responsable_ddw' => 
    array (
      'required' => false,
      'name' => 'tct_responsable_ddw',
      'vname' => 'LBL_TCT_RESPONSABLE_DDW',
      'type' => 'enum',
      'massupdate' => true,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '1',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'default' => '',
      'calculated' => false,
      'len' => 100,
      'size' => '20',
      'options' => 'tct_responsable_ddw_list',
      'dependency' => false,
    ),
    'tct_fecha_compromiso_c' => 
    array (
      'required' => false,
      'name' => 'tct_fecha_compromiso_c',
      'vname' => 'LBL_TCT_FECHA_COMPROMISO_C',
      'type' => 'date',
      'massupdate' => true,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '1',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'calculated' => false,
      'size' => '20',
      'enable_range_search' => false,
    ),
    'tct_generar_tarea_chk' => 
    array (
      'required' => false,
      'name' => 'tct_generar_tarea_chk',
      'vname' => 'LBL_TCT_GENERAR_TAREA_CHK',
      'type' => 'bool',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '1',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'default' => false,
      'calculated' => false,
      'len' => '255',
      'size' => '20',
    ),
    'tct_responsable_id_c' => 
    array (
      'required' => false,
      'name' => 'tct_responsable_id_c',
      'vname' => 'LBL_TCT_RESPONSABLE_ID_C',
      'type' => 'varchar',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => '1',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'default' => '',
      'full_text_search' => 
      array (
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
      ),
      'calculated' => false,
      'len' => '255',
      'size' => '20',
    ),
  ),
  'relationships' => 
  array (
  ),
);