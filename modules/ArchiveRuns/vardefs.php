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

$dictionary['ArchiveRuns'] = array(
    'table' => 'archive_runs',
    'archive' => false,
    'unified_search' => true,
    'full_text_search' => true,
    'unified_search_default_enabled' => true,
    'duplicate_merge' => true,
    'fields' => array(
        'archiver_id' => array(
            'name' => 'archiver_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_ARCHIVER_ID_FIELD',
            'audited' => true,
            'massupdate' => false,
            'comment' => 'ID associated with the Data Archiver',
        ),
        'date_of_archive' => array(
            'name' => 'date_of_archive',
            'vname' => 'LBL_DATE_OF_ARCHIVE_FIELD',
            'type' => 'datetime',
            'required' => true,
            'comment' => 'The date and time this archiver was run',
        ),
        'source_module' => array(
            'name' => 'source_module',
            'vname' => 'LBL_MODULE_FIELD',
            'type' => 'varchar',
            'required' => true,
            'comment' => 'The source module',
        ),
        'filter_def' => array(
            'name' => 'filter_def',
            'vname' => 'LBL_FILTER_DEF_FIELD',
            'type' => 'filter-def',
            'dbType' => 'text',
            'required' => true,
            'comment' => 'The filter definition associated with the run',
        ),
        'num_processed' => array(
            'name' => 'num_processed',
            'vname' => 'LBL_NUM_PROCESSED_FIELD',
            'type' => 'int',
            'required' => true,
            'comment' => 'The number of fields archived/deleted',
        ),
        'process_type' => array(
            'name' => 'process_type',
            'vname' => 'LBL_PROCESS_TYPE_FIELD',
            'type' => 'enum',
            'function' => 'getProcessTypes',
            'function_bean' => 'DataArchiver',
            'required' => true,
            'comment' => 'Whether the data was deleted or archived',
        ),
        'ids_processed' => array(
            'name' => 'ids_processed',
            'vname' => 'LBL_IDS_PROCESSED_FIELD',
            'type' => 'longtext',
            'required' => true,
            'comment' => 'The IDs that were processed in this run',
        ),
    ),
);

VardefManager::createVardef('ArchiveRuns', 'ArchiveRuns');
