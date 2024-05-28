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
$viewdefs['VisualPipeline']['base']['view']['config-visual-pipeline'] = array(
    'label' => 'LBL_VISUAL_PIPELINE_CONFIG_TITLE',
    'panels' => array(
        array(
            'fields' => array(
                array(
                    'name' => 'table_header',
                    'label' => 'LBL_PIPELINE_TABLE_HEADER',
                    'type' => 'table-header',
                    'span' => 6,
                ),
                array(
                    'name' => 'header_values',
                    'label' => 'LBL_PIPELINE_HEADER_VALUES',
                    'type' => 'header-values',
                    'span' => 6,
                ),
                array(
                    'name' => 'tile_header',
                    'label' => 'LBL_PIPELINE_TILE_HEADER',
                    'type' => 'table-header',
                    'enabled' => true,
                    'span' => 6,
                    'twoColumns' => true,
                ),

                array(
                    'name' => 'tile_body_fields',
                    'label' => 'LBL_PIPELINE_TILE_BODY_FIELDS',
                    'type' => 'modules-list',
                    'span' => 6,
                    'isMultiSelect' => true,
                    'ordered' => true,
                    'twoColumns' => true,
                ),
                array(
                    'name' => 'records_per_column',
                    'label' => 'LBL_PIPELINE_RECORDS_PER_COLUMN',
                    'type' => 'enum',
                    'enabled' => true,
                    'span' => 6,
                ),
            ),
        ),
    ),
);
