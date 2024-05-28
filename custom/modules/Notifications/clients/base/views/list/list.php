<?php
// created: 2024-05-21 12:55:59
$viewdefs['Notifications']['base']['view']['list'] = array (
  'favorites' => false,
  'panels' => 
  array (
    0 => 
    array (
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'severity',
          'type' => 'severity',
          'default' => true,
          'enabled' => true,
          'css_class' => 'full-width',
        ),
        1 => 
        array (
          'name' => 'name',
          'default' => true,
          'enabled' => true,
          'link' => true,
        ),
        2 => 
        array (
          'name' => 'parent_name',
          'label' => 'LBL_LIST_RELATED_TO',
          'id' => 'PARENT_ID',
          'link' => true,
          'default' => true,
          'enabled' => true,
          'sortable' => false,
        ),
        3 => 
        array (
          'name' => 'assigned_user_name',
          'sortable' => false,
          'enabled' => true,
          'default' => false,
        ),
        4 => 
        array (
          'name' => 'date_entered',
          'default' => false,
          'enabled' => true,
        ),
        5 => 
        array (
          'name' => 'date_modified',
          'default' => false,
          'enabled' => true,
        ),
        6 => 
        array (
          'name' => 'is_read',
          'default' => true,
          'enabled' => true,
        ),
      ),
    ),
  ),
  'orderBy' => 
  array (
    'field' => 'date_entered',
    'direction' => 'desc',
  ),
);