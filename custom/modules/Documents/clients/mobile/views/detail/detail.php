<?php
$viewdefs['Documents'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_DOC_NAME',
              ),
              1 => 
              array (
                'name' => 'related_doc_name',
                'comment' => 'The related document name for Meta-Data framework',
                'label' => 'LBL_DET_RELATED_DOCUMENT',
              ),
              2 => 'active_date',
              3 => 'category_id',
              4 => 'subcategory_id',
              5 => 'status_id',
              6 => 'team_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
