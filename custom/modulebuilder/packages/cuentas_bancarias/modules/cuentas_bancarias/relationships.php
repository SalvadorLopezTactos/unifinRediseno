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
  'cta_cuentas_bancarias_accounts' => 
  array (
    'rhs_label' => 'Cuentas',
    'lhs_label' => 'Cuentas Bancarias',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'cta_cuentas_bancarias',
    'rhs_module' => 'Accounts',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'cta_cuentas_bancarias_accounts',
  ),
);