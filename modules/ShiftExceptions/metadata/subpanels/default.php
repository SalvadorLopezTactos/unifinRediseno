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

$subpanel_layout = array(
    'list_fields' => array(
        'name' => array(
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'width' => '30%',
            'sortable' => true,
        ),
        'shift_exception_type' => array(
            'vname' => 'LBL_TYPE',
            'width' => '10%',
            'sortable' => true,
        ),
        'start_date' => array(
            'vname' => 'LBL_START_DATE',
            'width' => '10%',
            'sortable' => true,
        ),
        'end_date' => array(
            'vname' => 'LBL_END_DATE',
            'width' => '10%',
            'sortable' => true,
        ),
        'timezone' => array(
            'vname' => 'LBL_TIMEZONE',
            'width' => '20%',
            'sortable' => true,
        ),
        'all_day' => array(
            'vname' => 'LBL_ALL_DAY',
            'width' => '10%',
            'sortable' => true,
        ),
        'enabled' => array(
            'vname' => 'LBL_ENABLED',
            'width' => '10%',
            'sortable' => true,
        ),
    ),
);
