<?php
$module_name = 'TCT01_Encuestas';
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
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tct01_encuestas_meetings_name',
                'label' => 'LBL_TCT01_ENCUESTAS_MEETINGS_FROM_MEETINGS_TITLE',
                'enabled' => true,
                'id' => 'TCT01_ENCUESTAS_MEETINGSMEETINGS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
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
