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

$viewdefs['BusinessCenters']['base']['view']['list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'name',
                    'link' => true,
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'default' => true,
                    'width' =>  'xlarge',
                ),
                array(
                    'name' => 'address_country',
                    'label' => 'LBL_ADDRESS_COUNTRY',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'timezone',
                    'label' => 'LBL_TIMEZONE',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'address_street',
                    'label' => 'LBL_ADDRESS_STREET',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'address_city',
                    'label' => 'LBL_ADDRESS_CITY',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'address_state',
                    'label' => 'LBL_ADDRESS_STATE',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'address_postalcode',
                    'label' => 'LBL_ADDRESS_POSTALCODE',
                    'enabled' => true,
                    'default' => false,
                ),
                array(
                    'name' => 'team_name',
                    'label' => 'LBL_PRIMARY_TEAM',
                    'enabled' => true,
                    'default' => false,
                ),
                array (
                    'name' => 'assigned_user_name',
                    'label' => 'LBL_ASSIGNED_TO_NAME',
                    'id' => 'ASSIGNED_USER_ID',
                    'enabled' => true,
                    'default' => false,
                ),
                array (
                    'name' => 'date_entered',
                    'type' => 'datetime',
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'default' => false,
                    'readonly' => true,
                ),
                array(
                    'name' => 'date_modified',
                    'type' => 'datetime',
                    'label' => 'LBL_DATE_MODIFIED',
                    'enabled' => true,
                    'default' => false,
                    'readonly' => true,
                ),
                array(
                    'name' => 'created_by_name',
                    'label' => 'LBL_CREATED',
                    'enabled' => true,
                    'default' => false,
                    'readonly' => true,
                    'sortable' => true,
                ),
                array(
                    'name' => 'modified_by_name',
                    'label' => 'LBL_MODIFIED',
                    'enabled' => true,
                    'default' => false,
                    'readonly' => true,
                    'sortable' => true,
                ),
            ),
        ),
    ),
);
