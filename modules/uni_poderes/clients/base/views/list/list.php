<?php
$module_name = 'uni_poderes';
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
                'name' => 'apoderado',
                'label' => 'LBL_APODERADO',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'width' => '10%',
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'poderes',
                'label' => 'LBL_PODERES',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'forma',
                'label' => 'LBL_FORMA',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'mancomunado',
                'label' => 'LBL_MANCOMUNADO',
                'enabled' => true,
                'id' => 'ACCOUNT_ID1_C',
                'link' => true,
                'sortable' => false,
                'width' => '10%',
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'width' => '9%',
                'default' => false,
                'enabled' => true,
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
