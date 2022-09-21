<?php
$viewdefs['Cases'] = 
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
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'span' => 12,
              ),
            ),
          ),
          1 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'case_number',
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'date_entered',
              ),
              2 => 
              array (
                'name' => 'follow_up_datetime',
              ),
              3 => 
              array (
                'name' => 'resolved_datetime',
              ),
              4 => 
              array (
                'name' => 'account_name',
              ),
              5 => 
              array (
                'name' => 'case_cuenta_relacion',
                'studio' => 'visible',
                'label' => 'LBL_CASE_CUENTA_REL',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'vip_c',
                'label' => 'LBL_VIP',
                'span' => 12,
              ),
              7 => 
              array (
                'readonly' => false,
                'name' => 'producto_c',
                'label' => 'LBL_PRODUCTO',
              ),
              8 => 'type',
              9 => 
              array (
                'readonly' => false,
                'name' => 'subtipo_c',
                'label' => 'LBL_SUBTIPO',
              ),
              10 => 
              array (
                'readonly' => false,
                'name' => 'detalle_subtipo_c',
                'label' => 'LBL_DETALLE_SUBTIPO',
              ),
              11 => 'priority',
              12 => 'status',
              13 => 
              array (
                'name' => 'source',
              ),
              14 => 
              array (
              ),
              15 => 
              array (
                'readonly' => false,
                'name' => 'case_fcr_c',
                'label' => 'LBL_CASE_FCR',
              ),
              16 => 
              array (
                'readonly' => false,
                'name' => 'case_hd_c',
                'label' => 'LBL_CASE_HD',
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'assigned_user_name',
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'area_interna_c',
                'label' => 'LBL_AREA_INTERNA',
              ),
              2 => 
              array (
                'readonly' => false,
                'name' => 'equipo_soporte_c',
                'label' => 'LBL_EQUIPO_SOPORTE',
              ),
              3 => 
              array (
                'readonly' => false,
                'name' => 'responsable_interno_c',
                'studio' => 'visible',
                'label' => 'LBL_RESPONSABLE_INTERNO',
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'description',
                'nl2br' => true,
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'commentlog',
                'label' => 'LBL_COMMENTLOG',
                'span' => 12,
              ),
              2 => 
              array (
                'name' => 'resolution',
                'nl2br' => true,
                'span' => 12,
              ),
            ),
          ),
          4 => 
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
                'name' => 'codigo_producto_c',
                'label' => 'LBL_CODIGO_PRODUCTO',
                'span' => 12,
              ),
            ),
          ),
          5 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
            'hide' => true,
            'columns' => 2,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
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
              1 => 
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
              2 => 
              array (
                'name' => 'team_name',
              ),
              3 => 
              array (
                'readonly' => false,
                'name' => 'contacto_principal_c',
                'studio' => 'visible',
                'label' => 'LBL_CONTACTO_PRINCIPAL',
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
