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
  'dire_ciudad_dire_estado' => 
  array (
    'rhs_label' => 'dire_Estado',
    'lhs_label' => 'Ciudades',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'dire_Ciudad',
    'rhs_module' => 'dire_Estado',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'dire_ciudad_dire_estado',
  ),
);