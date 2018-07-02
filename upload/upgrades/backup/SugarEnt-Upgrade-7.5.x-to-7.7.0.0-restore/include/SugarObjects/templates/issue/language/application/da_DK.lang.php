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
	

$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_priority_dom' => 
  array (
    'P1' => 'Høj',
    'P2' => 'Mellem',
    'P3' => 'Lav',
  ),
  $object_name.'_resolution_dom' => 
  array (
    '' => '[-blank-]',
    'Accepted' => 'Accepteret',
    'Closed' => 'Lukket',
    'Duplicate' => 'Dupliker',
    'Invalid' => 'Ugyldig',
    'Out of Date' => 'Forældet',
  ),
  $object_name.'_status_dom' => 
  array (
    'Assigned' => 'Tildelt',
    'Closed' => 'Lukket',
    'Duplicate' => 'Dupliker',
    'New' => 'Ny',
    'Pending Input' => 'Afventer input',
    'Rejected' => 'Afvist',
  ),
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Administration',
    'Product' => 'Produkt',
    'User' => 'Bruger',
  ),
);

