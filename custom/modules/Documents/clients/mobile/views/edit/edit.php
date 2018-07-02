<?php
$viewdefs['Documents'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
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
              0 => 'document_name',
              1 => 'category_id',
              2 => 'subcategory_id',
              3 => 'status_id',
              4 => 'active_date',
              5 => 
              array (
                'name' => 'related_doc_name',
                'comment' => 'The related document name for Meta-Data framework',
                'label' => 'LBL_DET_RELATED_DOCUMENT',
                'css_class' => 'hide',
              ),
              6 => 'exp_date',
              7 => 
              array (
                'name' => 'filename_file',
                'css_class' => 'hide',
              ),
              8 => 
              array (
                'name' => 'filename',
                'css_class' => 'hide',
              ),
              9 => 'assigned_user_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
