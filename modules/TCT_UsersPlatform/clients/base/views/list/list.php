<?php
$module_name = 'TCT_UsersPlatform';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'tct_session_id_txf',
                'label' => 'LBL_TCT_SESSION_ID_TXF',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'tct_user_id_txf',
                'label' => 'LBL_TCT_USER_ID_TXF',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tct_platform_txf',
                'label' => 'LBL_TCT_PLATFORM_TXF',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              4 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              5 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              6 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
