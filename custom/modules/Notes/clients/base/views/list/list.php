<?php
$viewdefs['Notes'] = 
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
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_LIST_SUBJECT',
                'link' => true,
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_LIST_RELATED_TO',
                'dynamic_module' => 'PARENT_TYPE',
                'id' => 'PARENT_ID',
                'link' => true,
                'enabled' => true,
                'default' => true,
                'sortable' => false,
                'ACLTag' => 'PARENT',
                'related_fields' => 
                array (
                  0 => 'parent_id',
                  1 => 'parent_type',
                ),
              ),
              2 => 
              array (
                'name' => 'created_by_name',
                'type' => 'relate',
                'label' => 'LBL_CREATED_BY',
                'enabled' => true,
                'default' => true,
                'related_fields' => 
                array (
                  0 => 'created_by',
                ),
              ),
              3 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'relacion_nota_minuta_c',
                'label' => 'LBL_RELACION_NOTA_MINUTA_C',
                'enabled' => true,
                'id' => 'MINUT_MINUTAS_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
