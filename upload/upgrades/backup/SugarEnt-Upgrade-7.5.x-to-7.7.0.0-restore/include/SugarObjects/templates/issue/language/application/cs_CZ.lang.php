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






	
$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_status_dom' => 
  array (
    'Pending Input' => 'Až do vstupu',
    'Rejected' => 'Odmítnuto',
    'Duplicate' => 'Duplikát',
    'New' => 'Nový',
    'Assigned' => 'Přiřazený',
    'Closed' => 'Zavřený',
  ),
  $object_name.'_priority_dom' => 
  array (
    'P1' => 'Vysoký',
    'P2' => 'Střední',
    'P3' => 'Nízký',
  ),
  $object_name.'_resolution_dom' => 
  array (
    '' => '',
    'Accepted' => 'Přijatý',
    'Duplicate' => 'Duplikát',
    'Closed' => 'Zavřený',
    'Out of Date' => 'Zastaralý',
    'Invalid' => 'Neplatný',
  ),
  $object_name.'_type_dom' => 
  array (
    'Administration' => 'Administrace',
    'Product' => 'Produkt',
    'User' => 'Uživatel',
  ),
);

