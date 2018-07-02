<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$relationships = array (
  'tct2_notificaciones_accounts' => 
  array (
    'rhs_label' => 'Personas',
    'lhs_label' => 'Notificaciones',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'TCT2_Notificaciones',
    'rhs_module' => 'Accounts',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'tct2_notificaciones_accounts',
  ),
  'tct2_notificaciones_opportunities' => 
  array (
    'rhs_label' => 'Operaciones',
    'lhs_label' => 'Notificaciones',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'TCT2_Notificaciones',
    'rhs_module' => 'Opportunities',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'tct2_notificaciones_opportunities',
  ),
  'tct2_notificaciones_users' => 
  array (
    'rhs_label' => 'Usuarios',
    'lhs_label' => 'Notificaciones',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'TCT2_Notificaciones',
    'rhs_module' => 'Users',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'tct2_notificaciones_users',
  ),
);