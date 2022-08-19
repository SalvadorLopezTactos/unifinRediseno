<?php
$module_name = 'Cot_Cotizaciones';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'Cot_Cotizaciones',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
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
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
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
                'name' => 'statuscode',
                'label' => 'LBL_STATUSCODE',
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'int_id_dynamics',
                'label' => 'LBL_INT_ID_DYNAMICS',
              ),
              2 => 
              array (
                'name' => 'cot_cotizaciones_s_seguros_name',
              ),
              3 => 
              array (
                'readonly' => false,
                'name' => 'cot_ganada_c',
                'label' => 'LBL_COT_GANADA_C',
              ),
              4 => 
              array (
                'readonly' => false,
                'name' => 'aseguradora_c',
                'label' => 'LBL_ASEGURADORA',
              ),
              5 => 
              array (
                'readonly' => false,
                'name' => 'int_aseguradora_id_c',
                'label' => 'LBL_INT_ASEGURADORA_ID',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'int_indicativo',
                'label' => 'LBL_INT_INDICATIVO',
              ),
              7 => 
              array (
                'readonly' => false,
                'name' => 'int_prima_neta',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_INT_PRIMA_NETA',
              ),
              8 => 
              array (
                'readonly' => false,
                'name' => 'int_comision_porcentaje',
                'label' => 'LBL_INT_COMISION_PORCENTAJE',
              ),
              9 => 
              array (
                'readonly' => false,
                'name' => 'int_comision',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_INT_COMISION',
              ),
              10 => 
              array (
                'readonly' => false,
                'name' => 'int_porcentaje_comision_total',
                'label' => 'LBL_INT_PORCENTAJE_COMISION_TOTAL',
              ),
              11 => 
              array (
                'readonly' => false,
                'name' => 'int_porcentaje_sobrecomision',
                'label' => 'LBL_INT_PORCENTAJE_SOBRECOMISION',
              ),
              12 => 
              array (
                'readonly' => false,
                'name' => 'int_comision_documento',
                'label' => 'LBL_INT_COMISION_DOCUMENTO',
              ),
              13 => 
              array (
                'readonly' => false,
                'name' => 'int_honorarios_fee',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_INT_HONORARIOS_FEE',
              ),
              14 => 
              array (
                'readonly' => false,
                'name' => 'int_honorarios_fee_porcentaje',
                'label' => 'LBL_INT_HONORARIOS_FEE_PORCENTAJE',
              ),
              15 => 
              array (
                'readonly' => false,
                'name' => 'int_udi',
                'label' => 'LBL_INT_UDI',
              ),
              16 => 
              array (
                'readonly' => false,
                'name' => 'int_reaseguro',
                'label' => 'LBL_INT_REASEGURO',
              ),
              17 => 
              array (
                'readonly' => false,
                'name' => 'int_coaseguro',
                'label' => 'LBL_INT_COASEGURO',
              ),
              18 => 
              array (
                'name' => 'assigned_user_name',
              ),
              19 => 
              array (
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
                'name' => 'description',
                'span' => 12,
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
              3 => 
              array (
                'name' => 'tag',
              ),
              4 => 'team_name',
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);