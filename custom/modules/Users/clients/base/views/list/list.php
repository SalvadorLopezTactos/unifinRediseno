<?php
$viewdefs['Users']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'label' => 'LBL_PANEL_DEFAULT',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'label' => 'LBL_LIST_NAME',
          'type' => 'fullname',
          'fields' => 
          array (
            0 => 'first_name',
            1 => 'last_name',
          ),
          'enabled' => true,
          'default' => true,
          'sortable' => true,
          'link' => true,
          'width' => '20',
          'related_fields' => 
          array (
            0 => 'last_name',
            1 => 'first_name',
          ),
          'orderBy' => 'last_name',
        ),
        1 => 
        array (
          'name' => 'user_name',
          'sortable' => true,
          'default' => true,
          'enabled' => true,
          'width' => '15',
          'label' => 'LBL_USER_NAME',
          'link' => true,
        ),
        2 => 
        array (
          'name' => 'reports_to_name',
          'default' => true,
          'enabled' => true,
          'link' => true,
          'label' => 'LBL_REPORTS_TO_NAME',
          'id' => 'REPORTS_TO_ID',
          'sortable' => false,
          'width' => '20',
        ),
        3 => 
        array (
          'name' => 'status',
          'enabled' => true,
          'default' => true,
          'sortable' => true,
          'width' => '10',
          'label' => 'LBL_STATUS',
          'link' => false,
        ),
        4 => 
        array (
          'name' => 'is_group',
          'default' => false,
          'enabled' => true,
          'width' => '10',
          'label' => 'LBL_LIST_GROUP',
          'link' => true,
        ),
        5 => 
        array (
          'name' => 'license_type',
          'type' => 'enum',
          'readonly' => true,
          'enabled' => true,
          'default' => false,
          'sortable' => true,
          'width' => '20',
          'label' => 'LBL_LICENSE_TYPE',
          'link' => false,
        ),
      ),
    ),
  ),
);
