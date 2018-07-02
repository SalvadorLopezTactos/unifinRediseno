<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

$subpanel_layout = array(
    'top_buttons' => array(
        array('widget_class' => 'SubPanelTopCreateButton'),
    ),

    'where' => '',

    'list_fields' => array(
        'kbdocument_name' => array(
            'name'          => 'kbdocument_name',
            'width'         => '25%',
            'vname'         => 'LBL_LIST_DOCUMENT_NAME',
            'widget_class'  => 'SubPanelDetailViewLink',
        ),
        'status_id' => array(
            'name'  => 'status_id',
            'vname' => 'LBL_LIST_STATUS',
            'width' => '20%',
        ),
        'kbdoc_approver_name' => array(
            'name'    => 'kbdoc_approver_name',
            'width'   => '20%',
            'vname'   => 'LBL_LIST_APPROVED_BY',
            'default' => true,
        ),
        'date_modified' => array(
            'name'  => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'width' => '20%',
        ),
        'edit_button' => array(
            'widget_class' => 'SubPanelEditButton',
            'module'       => 'KBDocuments',
            'width'        => '5%',
        ),
        'remove_button' => array(
            'widget_class' => 'SubPanelRemoveButton',
            'module'       => 'KBDocuments',
            'width'        => '5%',
        ),
    ),
);

?>
