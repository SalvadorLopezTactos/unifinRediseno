<?php
// created: 2018-02-16 17:22:03
$viewdefs['Opportunities']['base']['view']['recordlist'] = array (
  'favorite' => true,
  'following' => true,
  'selection' => 
  array (
    'type' => 'multi',
    'actions' => 
    array (
      0 => 
      array (
        'name' => 'export_button',
        'type' => 'button',
        'label' => 'LBL_EXPORT',
        'acl_action' => 'export',
        'primary' => true,
        'events' => 
        array (
          'click' => 'list:massexport:fire',
        ),
      ),
    ),
  ),
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
      ),
      1 => 
      array (
        'type' => 'rowaction',
        'name' => 'edit_button',
        'label' => 'Expediente',
        'event' => 'list:expedienterow:fire',
        'acl_action' => 'edit',
      ),
    ),
  ),
  'last_state' => 
  array (
    'id' => 'record-list',
  ),
);