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
/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs['base']['view']['tutorial'] = [
    'records' => [
        'version' => 1,
        'intro' => 'LBL_TOUR_LIST_INTRO',
        'content' => [
            [
                'name' => '.sidebar-toggle',
                'text' => 'LBL_TOUR_LIST_INT_TOGGLE',
                'full' => true,
                'horizAdj' => -11,
                'vertAdj' => -13,
            ],
            [
                'name' => '.filter .search-filter',
                'text' => 'LBL_TOUR_LIST_FILTER1',
                'full' => true,
                'vertAdj' => -12,
            ],
            [
                'name' => '.choice-filter',
                'text' => 'LBL_TOUR_LIST_FILTER2',
                'full' => true,
                'vertAdj' => -15,
            ],
            [
                'name' => '.filter-view .search-name',
                'text' => 'LBL_TOUR_LIST_FILTER_SEARCH',
                'full' => true,
                'vertAdj' => -14,
            ],
            [
                'name' => '[data-view="activitystream"]',
                'text' => 'LBL_TOUR_LIST_ACTIVTYSTREAMLIST_TOGGLE',
                'full' => true,
                'horizAdj' => -10,
                'vertAdj' => -10,
            ],
            [
                'name' => '[data-event="list:preview:fire"]',
                'text' => 'LBL_TOUR_LIST_FILTER_PREVIEW',
                'full' => true,
                'vertAdj' => -15,
            ],
        ],
    ],
    'record' => [
        'version' => 1,
        'intro' => 'LBL_TOUR_RECORD_INTRO',
        'content' => [
            [
                'name' => '[data-fieldname="first_name"]',
                'text' => 'LBL_TOUR_RECORD_INLINEEDIT',
                'full' => true,
                'horizAdj' => -15,
                'vertAdj' => -13,
            ],
            [
                'name' => '[data-fieldname="name"]',
                'text' => 'LBL_TOUR_RECORD_INLINEEDIT',
                'full' => true,
                'horizAdj' => -11,
                'vertAdj' => -13,
            ],
            [
                'name' => '[name="edit_button"]',
                'text' => 'LBL_TOUR_RECORD_ACTIONS',
                'full' => true,
                'horizAdj' => -1,
                'vertAdj' => -13,
            ],
            [
                'name' => '.record .record-cell',
                'text' => 'LBL_TOUR_RECORD_INLINEEDITRECORD',
                'full' => true,
                'horizAdj' => -11,
                'vertAdj' => -13,
            ],
            [
                'name' => '[data-type="tag"]',
                'text' => 'LBL_TOUR_TAGS_ADD',
                'full' => true,
                'horizAdj' => -5,
                'vertAdj' => 1,
            ],
            [
                'name' => '.select2-container.select2-container-multi.select2-choices-pills-close.select2field',
                'text' => 'LBL_TOUR_TAGS_DELETE',
                'full' => true,
                'horizAdj' => 1,
                'vertAdj' => -11,
            ],
            [
                'name' => '.show-hide-toggle',
                'text' => 'LBL_TOUR_RECORD_SHOWMORE',
                'full' => true,
                'horizAdj' => 8,
                'vertAdj' => -13,
            ],
            [
                'name' => '[name="save_button"]',
                'text' => 'LBL_TOUR_RECORD_SAVE',
                'full' => true,
                'horizAdj' => -5,
                'vertAdj' => -11,
            ],
            [
                'name' => '.subpanel-header',
                'text' => 'LBL_TOUR_RECORD_SUBPANEL',
                'full' => true,
                'horizAdj' => -4,
                'vertAdj' => -4,
            ],
            [
                'name' => '[data-view="subpanel"]',
                'text' => 'LBL_TOUR_RECORD_TOGGLEACTIVITIES',
                'full' => true,
                'horizAdj' => -11,
                'vertAdj' => -13,
            ],
            [
                'name' => '.preview-headerbar .dropdown-toggle',
                'text' => 'LBL_TOUR_RECORD_DASHBOARDNAME',
                'full' => true,
                'horizAdj' => -11,
                'vertAdj' => -13,
            ],
            [
                'name' => '.preview-headerbar .btn-toolbar',
                'text' => 'LBL_TOUR_RECORD_DASHBOARDACTIONS',
                'full' => true,
                'horizAdj' => 8,
                'vertAdj' => 5,
            ],
            [
                'name' => '.dashlet-cell .sicon-settings',
                'text' => 'LBL_TOUR_RECORD_DASHLETCOG',
                'full' => true,
                'horizAdj' => -18,
                'vertAdj' => -18,
            ],
        ],
    ],
];
