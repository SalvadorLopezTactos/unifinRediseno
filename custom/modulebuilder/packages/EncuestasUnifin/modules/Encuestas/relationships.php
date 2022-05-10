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
  'tct01_encuestas_meetings' => 
  array (
    'rhs_label' => 'Reuniones',
    'lhs_label' => 'Encuestas',
    'lhs_subpanel' => 'default',
    'lhs_module' => 'TCT01_Encuestas',
    'rhs_module' => 'Meetings',
    'relationship_type' => 'many-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'tct01_encuestas_meetings',
  ),
);