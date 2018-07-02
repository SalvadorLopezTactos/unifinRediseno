<?php

$manifest = array (
  'acceptable_sugar_versions' => 
  array (
    0 => '7',
  ),
  'acceptable_sugar_flavors' => 
  array (
    0 => 'CE',
    1 => 'PRO',
    2 => 'ENT',
    3 => 'ULT',
    4 => 'CORP',
  ),
  'readme' => '',
  'key' => '',
  'author' => 'Lev',
  'description' => '',
  'icon' => '',
  'is_uninstallable' => 'true',
  'name' => 'Backlog-Dashlet_CondicionesFinancieras',
  'published_date' => '2016-04-03 13:17:28',
  'type' => 'module',
  'version' => '1.0',
  'remove_tables' => 'prompt',
);
$installdefs = array (
  'id' => 'custom',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras/condiciones_financieras.js',
      'to' => 'custom/clients/base/fields/condiciones_financieras/condiciones_financieras.js',
    ),
    1 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras/detail.hbs',
      'to' => 'custom/clients/base/fields/condiciones_financieras/detail.hbs',
    ),
    2 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras/edit-condiciones-financieras.hbs',
      'to' => 'custom/clients/base/fields/condiciones_financieras/edit-condiciones-financieras.hbs',
    ),
    3 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras/edit.hbs',
      'to' => 'custom/clients/base/fields/condiciones_financieras/edit.hbs',
    ),
    4 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/condiciones_financieras_incremento_ratificacion.js',
      'to' => 'custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/condiciones_financieras_incremento_ratificacion.js',
    ),
    5 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/detail.hbs',
      'to' => 'custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/detail.hbs',
    ),
    6 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/edit-condiciones_financieras_incremento_ratificacion.hbs',
      'to' => 'custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/edit-condiciones_financieras_incremento_ratificacion.hbs',
    ),
    7 => 
    array (
      'from' => '<basepath>/custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/edit.hbs',
      'to' => 'custom/clients/base/fields/condiciones_financieras_incremento_ratificacion/edit.hbs',
    ),
    8 => 
    array (
      'from' => '<basepath>/custom/clients/base/views/backlog-dashlet/backlog-dashlet.hbs',
      'to' => 'custom/clients/base/views/backlog-dashlet/backlog-dashlet.hbs',
    ),
    9 => 
    array (
      'from' => '<basepath>/custom/clients/base/views/backlog-dashlet/backlog-dashlet.js',
      'to' => 'custom/clients/base/views/backlog-dashlet/backlog-dashlet.js',
    ),
    10 => 
    array (
      'from' => '<basepath>/custom/clients/base/views/backlog-dashlet/backlog-dashlet.php',
      'to' => 'custom/clients/base/views/backlog-dashlet/backlog-dashlet.php',
    ),
    11 => 
    array (
      'from' => '<basepath>/custom/Levementum/UnifinAPI.php',
      'to' => 'custom/Levementum/UnifinAPI.php',
    ),
    12 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/lev_Backlog/Ext/Dependencies/readOnly.php',
      'to' => 'custom/Extension/modules/lev_Backlog/Ext/Dependencies/readOnly.php',
    ),
    13 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/lev_Backlog/Ext/LogicHooks/backlog_hooks_array.php',
      'to' => 'custom/Extension/modules/lev_Backlog/Ext/LogicHooks/backlog_hooks_array.php',
    ),
    14 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/lev_CondicionesFinancieras/Ext/Language/es_ES.lev_backlog.php',
      'to' => 'custom/Extension/modules/lev_CondicionesFinancieras/Ext/Language/es_ES.lev_backlog.php',
    ),
    15 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/Language/es_ES.lang.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/Language/es_ES.lang.php',
    ),
    16 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/LogicHooks/condiciones_financieras.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/LogicHooks/condiciones_financieras.php',
    ),
    17 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/LogicHooks/condiciones_financieras_incremento_ratificacion.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/LogicHooks/condiciones_financieras_incremento_ratificacion.php',
    ),
    18 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/LogicHooks/crea_backlog.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/LogicHooks/crea_backlog.php',
    ),
    19 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/Dependencies/SetRequired.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/Dependencies/SetRequired.php',
    ),
    20 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/Vardefs/condiciones_financieras.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/Vardefs/condiciones_financieras.php',
    ),
    21 => 
    array (
      'from' => '<basepath>/custom/Extension/modules/Opportunities/Ext/Vardefs/condiciones_financieras_incremento_ratificacion.php',
      'to' => 'custom/Extension/modules/Opportunities/Ext/Vardefs/condiciones_financieras_incremento_ratificacion.php',
    ),
    22 => 
    array (
      'from' => '<basepath>/custom/modules/lev_Backlog/clients/base/views/create-actions/create-actions.js',
      'to' => 'custom/modules/lev_Backlog/clients/base/views/create-actions/create-actions.js',
    ),
    23 => 
    array (
      'from' => '<basepath>/custom/modules/lev_Backlog/clients/base/views/record/record.js',
      'to' => 'custom/modules/lev_Backlog/clients/base/views/record/record.js',
    ),
    24 => 
    array (
      'from' => '<basepath>/custom/modules/lev_Backlog/backlog_hooks.php',
      'to' => 'custom/modules/lev_Backlog/backlog_hooks.php',
    ),
    25 => 
    array (
      'from' => '<basepath>/custom/modules/Opportunities/clients/base/views/create-actions/create-actions.js',
      'to' => 'custom/modules/Opportunities/clients/base/views/create-actions/create-actions.js',
    ),
    26 => 
    array (
      'from' => '<basepath>/custom/modules/Opportunities/clients/base/views/record/record.js',
      'to' => 'custom/modules/Opportunities/clients/base/views/record/record.js',
    ),
    27 => 
    array (
      'from' => '<basepath>/custom/modules/Opportunities/opp_logic_hooks.php',
      'to' => 'custom/modules/Opportunities/opp_logic_hooks.php',
    ),
  ),
);

?>