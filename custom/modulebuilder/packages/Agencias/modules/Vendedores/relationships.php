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
$relationships = array (
  'ag_vendedores_ag_agencias' => 
  array (
    'rhs_label' => 'Agencias',
    'lhs_label' => 'Vendedores',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'AG_Vendedores',
    'rhs_module' => 'AG_Agencias',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'ag_vendedores_ag_agencias',
  ),
);