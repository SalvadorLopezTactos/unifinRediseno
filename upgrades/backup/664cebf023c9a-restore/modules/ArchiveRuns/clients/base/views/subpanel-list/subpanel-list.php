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
$viewdefs['ArchiveRuns']['base']['view']['subpanel-list'] = array(
    'template' => 'flex-list',
    'sticky_resizable_columns' => true,
    'favorite' => false,
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'label' => 'LBL_DATE_OF_ARCHIVE_FIELD',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_of_archive',
                ),
                array(
                    'label' => 'LBL_PROCESS_TYPE_FIELD',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'process_type',
                ),
                array(
                    'label' => 'LBL_MODULE_FIELD',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'source_module',
                ),
                array(
                    'label' => 'LBL_FILTER_DEF_FIELD',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'filter_def',
                    'type' => 'filter-def',
                    'sortable' => false,
                ),
                array(
                     'label' => 'LBL_NUM_PROCESSED_FIELD',
                     'enabled' => true,
                     'default' => true,
                     'name' => 'num_processed',
                ),
                array(
                    'label' => 'LBL_SOURCE_FIELD',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'created_by',
                ),
            ),
        ),
    ),
    'rowactions' => array(
        'actions' => array(
            array(
            ),
        ),
    ),
);
