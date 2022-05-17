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
    'condicion' => 
    array (
      'required' => false,
      'name' => 'condicion',
      'vname' => 'LBL_CONDICION',
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
      'pii' => false,
      'default' => '',
      'calculated' => false,
      'len' => 100,
      'size' => '20',
      'options' => 'condicion_cliente_list',
      'dependency' => false,
    ),
    'razon' => 
    array (
      'required' => false,
      'name' => 'razon',
      'vname' => 'LBL_RAZON',
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
      'pii' => false,
      'default' => '',
      'calculated' => false,
      'len' => 100,
      'size' => '20',
      'options' => 'razon_list',
      'dependency' => false,
      'visibility_grid' => 
      array (
        'trigger' => 'condicion',
        'values' => 
        array (
          1 => 
          array (
            0 => '1',
            1 => '2',
            2 => '3',
            3 => '4',
          ),
          2 => 
          array (
            0 => '5',
          ),
          3 => 
          array (
            0 => '6',
          ),
          4 => 
          array (
            0 => '7',
            1 => '8',
            2 => '9',
            3 => '10',
          ),
          5 => 
          array (
            0 => '11',
            1 => '12',
            2 => '13',
            3 => '14',
          ),
          '' => 
          array (
          ),
        ),
      ),
    ),
    'motivo' => 
    array (
      'required' => false,
      'name' => 'motivo',
      'vname' => 'LBL_MOTIVO',
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
      'pii' => false,
      'default' => '',
      'calculated' => false,
      'len' => 100,
      'size' => '20',
      'options' => 'motivo_bloqueo_list',
      'dependency' => false,
      'visibility_grid' => 
      array (
        'trigger' => 'razon',
        'values' => 
        array (
          1 => 
          array (
          ),
          2 => 
          array (
          ),
          3 => 
          array (
          ),
          4 => 
          array (
          ),
          5 => 
          array (
          ),
          6 => 
          array (
            0 => '1',
          ),
          7 => 
          array (
          ),
          8 => 
          array (
          ),
          9 => 
          array (
            0 => '2',
          ),
          10 => 
          array (
            0 => '3',
            1 => '4',
            2 => '5',
            3 => '6',
            4 => '7',
            5 => '16',
            6 => '8',
            7 => '9',
            8 => '10',
            9 => '11',
            10 => '12',
          ),
          11 => 
          array (
            0 => '13',
            1 => '14',
            2 => '15',
            3 => '16',
            4 => '17',
          ),
          12 => 
          array (
            0 => '18',
            1 => '19',
            2 => '20',
          ),
          13 => 
          array (
            0 => '21',
          ),
          14 => 
          array (
            0 => '22',
            1 => '23',
          ),
          '' => 
          array (
          ),
        ),
      ),
    ),
    'detalle' => 
    array (
      'required' => false,
      'name' => 'detalle',
      'vname' => 'LBL_DETALLE',
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
      'pii' => false,
      'default' => false,
      'calculated' => false,
      'size' => '20',
    ),
    'bloquea' => 
    array (
      'required' => false,
      'name' => 'bloquea',
      'vname' => 'LBL_BLOQUEA',
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
      'pii' => false,
      'default' => false,
      'calculated' => false,
      'size' => '20',
    ),
    'notifica' => 
    array (
      'required' => false,
      'name' => 'notifica',
      'vname' => 'LBL_NOTIFICA',
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
      'pii' => false,
      'default' => false,
      'calculated' => false,
      'size' => '20',
    ),
    'user_id_c' => 
    array (
      'required' => false,
      'name' => 'user_id_c',
      'vname' => 'LBL_RESPONSABLE1_USER_ID',
      'type' => 'id',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'audited' => false,
      'reportable' => false,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'pii' => false,
      'calculated' => false,
      'len' => 36,
      'size' => '20',
    ),
    'responsable1' => 
    array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'responsable1',
      'vname' => 'LBL_RESPONSABLE1',
      'type' => 'relate',
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
      'pii' => false,
      'calculated' => false,
      'len' => 255,
      'size' => '20',
      'id_name' => 'user_id_c',
      'ext2' => 'Teams',
      'module' => 'Teams',
      'rname' => 'name',
      'quicksearch' => 'enabled',
      'studio' => 'visible',
    ),
    'user_id1_c' => 
    array (
      'required' => false,
      'name' => 'user_id1_c',
      'vname' => 'LBL_RESPONSABLE2_USER_ID',
      'type' => 'id',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'enabled',
      'duplicate_merge_dom_value' => 1,
      'audited' => false,
      'reportable' => false,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'pii' => false,
      'calculated' => false,
      'len' => 36,
      'size' => '20',
    ),
    'responsable2' => 
    array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'responsable2',
      'vname' => 'LBL_RESPONSABLE2',
      'type' => 'relate',
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
      'pii' => false,
      'calculated' => false,
      'len' => 255,
      'size' => '20',
      'id_name' => 'user_id1_c',
      'ext2' => 'Teams',
      'module' => 'Teams',
      'rname' => 'name',
      'quicksearch' => 'enabled',
      'studio' => 'visible',
    ),
    'name' => 
    array (
      'name' => 'name',
      'vname' => 'LBL_NAME',
      'type' => 'name',
      'dbType' => 'varchar',
      'len' => '255',
      'unified_search' => true,
      'full_text_search' => 
      array (
        'enabled' => true,
        'boost' => '1.55',
        'searchable' => true,
      ),
      'required' => true,
      'importable' => 'false',
      'duplicate_merge' => 'disabled',
      'merge_filter' => 'disabled',
      'duplicate_on_record_copy' => 'always',
      'massupdate' => false,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'reportable' => true,
      'pii' => false,
      'calculated' => '1',
      'formula' => 'concat(getDropdownValue("condicion_cliente_list",$condicion),"-",getDropdownValue("razon_list",$razon),"-",getDropdownValue("motivo_bloqueo_list",$motivo))',
      'enforced' => true,
      'size' => '20',
    ),
  ),
  'relationships' => 
  array (
  ),
);