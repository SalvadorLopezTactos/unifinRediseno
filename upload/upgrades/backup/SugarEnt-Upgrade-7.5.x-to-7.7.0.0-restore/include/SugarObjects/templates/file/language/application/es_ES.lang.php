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


 
$app_list_strings = array (
strtolower($object_name).'_category_dom' =>
    array (
    '' => '',
    'Marketing' => 'Marketing',
    'Knowledege Base' => 'Base de Conocimiento',
    'Sales' => 'Ventas',
  ),

    strtolower($object_name).'_subcategory_dom' =>
    array (
    '' => '',
    'Marketing Collateral' => 'Impresos de Marketing',
    'Product Brochures' => 'Folletos de Producto',
    'FAQ' => 'FAQ',
  ),

    strtolower($object_name).'_status_dom' =>
    array (
    'Active' => 'Activo',
    'Draft' => 'Borrador',
    'FAQ' => 'FAQ',
    'Expired' => 'Caducado',
    'Under Review' => 'En Revisión',
    'Pending' => 'Pendiente',
  ),
  );
?>
