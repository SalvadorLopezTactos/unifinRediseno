<?php

/* This file was updated by 7_FixNameLink.php */
$viewdefs['Users']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'sortable' => true,
          'width' => '20%',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'user_name',
          'label' => 'LBL_USER_NAME',
          'sortable' => true,
          'width' => '15%',
          'default' => true,
          'enabled' => true,
        ),
        2 => 
        array (
          'name' => 'reports_to_name',
          'label' => 'LBL_REPORTS_TO_NAME',
          'enabled' => true,
          'id' => 'REPORTS_TO_ID',
          'link' => true,
          'sortable' => false,
          'width' => '20%',
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'email',
          'width' => '20%',
          'label' => 'LBL_EMAIL',
          'enabled' => true,
          'default' => true,
          'sortable' => true,
        ),
        4 => 
        array (
          'name' => 'status',
          'label' => 'LBL_STATUS',
          'enabled' => true,
          'default' => true,
          'sortable' => true,
          'width' => '10%',
        ),
        5 => 
        array (
          'name' => 'is_admin',
          'label' => 'LBL_IS_ADMIN',
          'enabled' => true,
          'default' => true,
          'sortable' => true,
          'width' => '10%',
        ),
        6 => 
        array (
          'name' => 'is_group',
          'label' => 'LBL_GROUP_USER',
          'enabled' => true,
          'width' => '10%',
          'default' => false,
        ),
      ),
    ),
  ),
);
