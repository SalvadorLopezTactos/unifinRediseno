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



$listViewDefs['KBDocuments'] = array(
	'KBDOCUMENT_NAME' => array(
		'width' => '25', 
        'label' => 'LBL_ARTICLE_TITLE', 
		'link' => true,
        'default' => true,
        'tablename'=>'KBDocuments',
        ),

    'VIEWS_NUMBER' => array(
        'width' => '5', 
        'label' => 'LBL_LIST_VIEWING_FREQUENCY',
        'tablename'=>'KBDocuments',
        'default' => true
        ),   

     'KBDOC_APPROVER_NAME' => array (
        'width' => '10', 
        'label' =>  'LBL_LIST_KBDOC_APPROVER_NAME',
        'default' => true,
        'tablename'=>'KBDocuments',
        ),

    'ASSIGNED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_ARTICLE_AUTHOR_LIST',
        'default' => true,
        'tablename'=>'KBDocuments',
        ),

    'DATE_ENTERED' => array(
        'width' => '10', 
        'label' => 'LBL_DATE_ENTERED',
        'default' => true,
        'tablename'=>'KBDocuments',
        ),  
         

     );
?>