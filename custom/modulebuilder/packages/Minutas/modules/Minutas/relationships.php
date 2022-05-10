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
  'minut_minutas_meetings' => 
  array (
    'lhs_module' => 'minut_Minutas',
    'rhs_module' => 'Meetings',
    'relationship_type' => 'one-to-one',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'minut_minutas_meetings',
  ),
  'minut_minutas_minut_participantes' => 
  array (
    'rhs_label' => 'Participantes',
    'lhs_label' => 'Minutas',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'minut_Minutas',
    'rhs_module' => 'minut_Participantes',
    'relationship_type' => 'one-to-many',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'minut_minutas_minut_participantes',
  ),
  'minut_minutas_minut_objetivos' => 
  array (
    'rhs_label' => 'Objetivos',
    'lhs_label' => 'Minutas',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'minut_Minutas',
    'rhs_module' => 'minut_Objetivos',
    'relationship_type' => 'one-to-many',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'minut_minutas_minut_objetivos',
  ),
  'minut_minutas_minut_compromisos' => 
  array (
    'rhs_label' => 'Compromisos',
    'lhs_label' => 'Minutas',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'minut_Minutas',
    'rhs_module' => 'minut_Compromisos',
    'relationship_type' => 'one-to-many',
    'readonly' => false,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => false,
    'relationship_name' => 'minut_minutas_minut_compromisos',
  ),
);