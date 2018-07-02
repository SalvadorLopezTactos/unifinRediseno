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

  $object_name.'_type_dom' =>
  array (
   'Administration' => 'Amministrazione',
    'Product' => 'Prodotto',
    'User' => 'Utente',
  ),
   $object_name.'_status_dom' =>
  array (
    'New' => 'Nuovo',
    'Assigned' => 'Assegnato',
    'Closed' => 'Chiuso',
    'Pending Input' => 'In attesa di input',
    'Rejected' => 'Respinto',
    'Duplicate' => 'Duplicato',
  ),
  $object_name.'_priority_dom' =>
  array (
    'P1' => 'Alta',
    'P2' => 'Media',
    'P3' => 'Bassa',
  ),
  $object_name.'_resolution_dom' =>
  array (
   '' => '',
   'Accepted' => 'Accettato',
    'Duplicate' => 'Duplicato',
    'Closed' => 'Chiuso',
    'Out of Date' => 'Non aggiornato',
    'Invalid' => 'Non valido',
  ),
  );
?>