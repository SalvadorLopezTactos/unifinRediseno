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
  'opera_operaciones_accounts' => 
  array (
    'rhs_label' => 'Personas',
    'lhs_label' => 'Cliente ',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'Opera_Operaciones',
    'rhs_module' => 'Accounts',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'opera_operaciones_accounts',
  ),
  'opera_operaciones_users' => 
  array (
    'rhs_label' => 'Users',
    'lhs_label' => 'Promotor',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'Opera_Operaciones',
    'rhs_module' => 'Users',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'opera_operaciones_users',
  ),
);