<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


$viewdefs['Employees']['mobile']['view']['list'] = array(
    'panels' => array(
        array(
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => array(
                array(
                    'name' => 'name',
                    'width' => '20%',
                    'label' => 'LBL_NAME',
                    'link' => true,
                    'orderBy' => 'last_name',
                    'default' => true,
                    'enabled' => true,
                    'related_fields' => array('first_name', 'last_name', 'salutation'),
                ),
                array(
                    'name' => 'title',
                    'width' => '15%',
                    'label' => 'LBL_TITLE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'email',
                    'width' => '15%',
                    'label' => 'LBL_EMAIL',
                    'sortable' => false,
                    'link' => true,
                    'customCode' => '{$EMAIL_LINK}{$EMAIL}</a>',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_work',
                    'width' => '15%',
                    'label' => 'LBL_OFFICE_PHONE',
                    'default' => true,
                    'enabled' => true,
                ),
                array(
                    'name' => 'phone_home',
                    'width' => '10',
                    'label' => 'LBL_HOME_PHONE',
                    'default' => false,
                ),
                array(
                    'name' => 'phone_mobile',
                    'width' => '10',
                    'label' => 'LBL_MOBILE_PHONE',
                    'default' => false,
                ),
                array(
                    'name' => 'phone_other',
                    'width' => '10',
                    'label' => 'LBL_WORK_PHONE',
                    'default' => false,
                ),
                array(
                    'name' => 'phone_fax',
                    'width' => '10',
                    'label' => 'LBL_FAX_PHONE',
                    'default' => false,
                ),
                array(
                    'name' => 'address_street',
                    'width' => '10',
                    'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                    'default' => false,
                ),
                array(
                    'name' => 'address_city',
                    'width' => '10',
                    'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                    'default' => false,
                ),
                array(
                    'name' => 'address_state',
                    'width' => '10',
                    'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                    'default' => false,
                ),
                array(
                    'name' => 'address_postalcode',
                    'width' => '10',
                    'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                    'default' => false,
                ),
                array(
                    'name' => 'date_entered',
                    'width' => '10',
                    'label' => 'LBL_DATE_ENTERED',
                    'default' => false,
                    'readonly' => true,
                ),
                array (
                    'name' => 'picture',
                    'label' => 'LBL_PICTURE_FILE',
                    'enabled' => true,
                    'width' => '10%',
                    'default' => true,
                ),
                array(
                    'name' => 'team_name',
                    'width' => '10',
                    'label' => 'LBL_TEAM',
                    'default' => true,
                    'enabled' => true,
                ),
            ))));
?>
