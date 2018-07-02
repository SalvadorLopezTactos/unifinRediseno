<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

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
/*********************************************************************************
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

$viewdefs["Emails"]["base"]["view"]["compose-addressbook-recipientscontainer"] = array(
    'template' => 'record',
    "panels" => array(
        array(
            "name"         => "selected_recipients",
            "columns"      => 1,
            "labels"       => true,
            "labelsOnTop"  => true,
            "placeholders" => true,
            "fields"       => array(
                array(
                    "name"                => "compose_addressbook_selected_recipients",
                    "type"                => "recipients",
                    "label"               => "LBL_SELECTED_RECIPIENTS",
                    "css_class_container" => "controls-one btn-fit",
                    'readonly'            => true,
                    "span"                => 12,
                ),
            ),
        ),
    ),
);

