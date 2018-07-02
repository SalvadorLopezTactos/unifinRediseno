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




if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


	
$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_subcategory_dom' => 
  array (
    'FAQ' => 'Frågor och svar',
    '' => '',
    'Marketing Collateral' => 'Marknadsmaterial',
    'Product Brochures' => 'Produkt broschyrer',
  ),
  $object_name.'_category_dom' => 
  array (
    '' => '',
    'Marketing' => 'Marknad',
    'Knowledege Base' => 'Kunskapsbas',
    'Sales' => 'Sälj',
  ),
  $object_name.'_status_dom' => 
  array (
    'Active' => 'Aktiv',
    'Draft' => 'Utkast',
    'FAQ' => 'Frågor och svar',
    'Expired' => 'Utgången',
    'Under Review' => 'Under granskning',
    'Pending' => 'Avvaktar',
  ),
);

