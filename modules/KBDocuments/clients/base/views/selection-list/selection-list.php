<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['KBDocuments']['base']['view']['selection-list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'kbdocument_name',
                    'width' => '45%',
                    'label' => 'LBL_ARTICLE_TITLE',
                    'link' => true,
                    'bwcLink' => false,
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'views_number',
                    'width' => '10%',
                    'label' => 'LBL_LIST_VIEWING_FREQUENCY',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'kbdoc_approver_name',
                    'width' => '10%',
                    'label' => 'LBL_LIST_KBDOC_APPROVER_NAME',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'assigned_user_name',
                    'width' => '10%',
                    'label' => 'LBL_ARTICLE_AUTHOR_LIST',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'active_date',
                    'label' => 'LBL_DOC_ACTIVE_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => false,
                ),
                array(
                    'name' => 'exp_date',
                    'label' => 'LBL_DOC_EXP_DATE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => false,
                ),
                array(
                    'name' => 'date_entered',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => false,
                    'readonly' => true,
                ),
                array(
                    'name' => 'kbdocument_revision_number',
                    'label' => 'LBL_KBDOCUMENT_REVISION_NUMBER',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => false,
                ),
            ),
        ),
    ),
);
