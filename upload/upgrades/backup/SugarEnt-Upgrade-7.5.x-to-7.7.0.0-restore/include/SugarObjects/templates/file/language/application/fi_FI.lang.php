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

$app_list_strings =
array (
  strtolower($object_name).'_category_dom' =>
  array (
    '' => '',
    'Marketing' => 'Markkinointi',
    'Knowledege Base' => 'Tietovarasto',
    'Sales' => 'Uusi liidi',
  ),
  strtolower($object_name).'_subcategory_dom' =>
  array (
    '' => '',
    'Marketing Collateral' => 'Markkinointimateriaali',
    'Product Brochures' => 'Tuote-esitteet',
    'FAQ' => 'Kysymykset',
  ),
  strtolower($object_name).'_status_dom' =>
  array (
    'Active' => 'Aktiivinen',
    'Draft' => 'Luonnos',
    'FAQ' => 'Kysymykset',
    'Expired' => 'Vanhentunut',
    'Under Review' => 'Arvioidaan',
    'Pending' => 'Odottaa',
  ),
);

