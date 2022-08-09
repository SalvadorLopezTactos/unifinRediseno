<?php
$module_name = 'QPRO_Gestion_Encuestas';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'preview' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
                'readonly' => true,
                'size' => 'large',
              ),
              1 => 'name',
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'readonly' => false,
                'name' => 'tipo',
                'label' => 'LBL_TIPO',
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'tipo_envio',
                'label' => 'LBL_TIPO_ENVIO',
              ),
              2 => 
              array (
                'readonly' => false,
                'name' => 'estatus',
                'label' => 'LBL_ESTATUS',
              ),
              3 => 
              array (
                'readonly' => false,
                'name' => 'fecha_expiracion',
                'label' => 'LBL_FECHA_EXPIRACION',
              ),
              4 => 
              array (
                'readonly' => false,
                'name' => 'url',
                'label' => 'LBL_URL',
              ),
              5 => 
              array (
                'readonly' => false,
                'name' => 'plantilla',
                'label' => 'LBL_PLANTILLA',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'encuesta_id',
                'label' => 'LBL_ENCUESTA_ID',
              ),
              7 => 
              array (
                'readonly' => false,
                'name' => 'template_id',
                'label' => 'LBL_TEMPLATE_ID',
              ),
              8 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              1 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
              2 => 
              array (
                'name' => 'assigned_user_name',
              ),
              3 => 
              array (
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'maxColumns' => 1,
        ),
      ),
    ),
  ),
);
