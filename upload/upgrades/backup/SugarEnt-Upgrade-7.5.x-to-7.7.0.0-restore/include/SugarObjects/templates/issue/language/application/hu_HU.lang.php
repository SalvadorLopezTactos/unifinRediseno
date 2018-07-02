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
    'P1' => 'Magas',
    'P2' => 'Közepes',
    'P3' => 'Alacsony',
  ),
  $object_name.'_resolution_dom' => 
  array (
    '' => '[-üres-]',
    'Accepted' => 'Elfogadott',
    'Closed' => 'Lezárt',
    'Duplicate' => 'Másolat',
    'Invalid' => 'Érvénytelen',
    'Out of Date' => 'Lejárt',
  ),
  $object_name.'_status_dom' => 
  array (
    'Assigned' => 'Hozzárendelve',
    'Closed' => 'Zárva',
    'Duplicate' => 'Másolat',
    'New' => 'Új',
    'Pending Input' => 'Függőben lévő bevitel',
    'Rejected' => 'Elutasítva',
  ),
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Adminisztráció',
    'Product' => 'Termék',
    'User' => 'Felhasználó',
  ),
);

