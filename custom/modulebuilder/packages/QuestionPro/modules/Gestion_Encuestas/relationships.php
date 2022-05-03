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
  'qpro_gestion_encuestas_qpro_encuestas' => 
  array (
    'rhs_label' => 'Encuestas',
    'lhs_label' => 'Gestión de Encuestas',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'QPRO_Gestion_Encuestas',
    'rhs_module' => 'QPRO_Encuestas',
    'relationship_type' => 'one-to-many',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'qpro_gestion_encuestas_qpro_encuestas',
  ),
);