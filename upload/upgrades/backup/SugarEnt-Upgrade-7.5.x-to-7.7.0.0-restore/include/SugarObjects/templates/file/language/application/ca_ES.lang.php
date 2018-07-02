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
/*********************************************************************************
 * Description:  Defines the Catalan language pack for the base application. 

 * Source: SugarCRM 5.2.0
 * Contributor(s): Ramón Feliu (ramon@slay.es).
 ********************************************************************************/
 
$app_list_strings = array (
strtolower($object_name).'_category_dom' =>
    array (
    '' => '',
    'Marketing' => 'Marketing',
    'Knowledege Base' => 'Base de Coneixament',
    'Sales' => 'Vendes',
  ),

    strtolower($object_name).'_subcategory_dom' =>
    array (
    '' => '',
    'Marketing Collateral' => 'Impressos de Marketing',
    'Product Brochures' => 'Fullets de Producte',
    'FAQ' => 'FAQ',
  ),

    strtolower($object_name).'_status_dom' =>
    array (
    'Active' => 'Actiu',
    'Draft' => 'Borrador',
    'FAQ' => 'FAQ',
    'Expired' => 'Caducat',
    'Under Review' => 'En Revisió',
    'Pending' => 'Pendent',
  ),
  );
?>
