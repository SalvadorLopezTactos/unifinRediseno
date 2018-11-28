<?php
$module_name = 'tct02_Resumen';
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
                'acl_module' => 'tct02_Resumen',
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
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'id_persona',
                'label' => 'LBL_ID_PERSONA',
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'leasing_fecha_pago',
                'label' => 'LBL_LEASING_FECHA_PAGO',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'leasing_anexos_activos',
                'label' => 'LBL_LEASING_ANEXOS_ACTIVOS',
              ),
              3 => 
              array (
                'name' => 'leasing_anexos_historicos',
                'label' => 'LBL_LEASING_ANEXOS_HISTORICOS',
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'factoring_fecha_pago',
                'label' => 'LBL_FACTORING_FECHA_PAGO',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'factoring_anexos_activos',
                'label' => 'LBL_FACTORING_ANEXOS_ACTIVOS',
              ),
              3 => 
              array (
                'name' => 'factoring_anexos_historicos',
                'label' => 'LBL_FACTORING_ANEXOS_HISTORICOS',
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'cauto_fecha_pago',
                'label' => 'LBL_CAUTO_FECHA_PAGO',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'cauto_anexos_activos',
                'label' => 'LBL_CAUTO_ANEXOS_ACTIVOS',
              ),
              3 => 
              array (
                'name' => 'cauto_anexos_historicos',
                'label' => 'LBL_CAUTO_ANEXOS_HISTORICOS',
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'impago_leasing_fecha_c',
                'label' => 'LBL_IMPAGO_LEASING_FECHA',
              ),
              1 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'impago_leasing_monto_c',
                'label' => 'LBL_IMPAGO_LEASING_MONTO',
              ),
              2 => 
              array (
                'name' => 'impago_factoring_fecha_c',
                'label' => 'LBL_IMPAGO_FACTORING_FECHA',
              ),
              3 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'impago_factoring_monto_c',
                'label' => 'LBL_IMPAGO_FACTORING_MONTO',
              ),
              4 => 
              array (
                'name' => 'impago_cauto_fecha_c',
                'label' => 'LBL_IMPAGO_CAUTO_FECHA',
              ),
              5 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'name' => 'impago_cauto_monto_c',
                'label' => 'LBL_IMPAGO_CAUTO_MONTO',
              ),
              6 => 
              array (
                'name' => 'impago_leasing_anexos_c',
                'studio' => 'visible',
                'label' => 'LBL_IMPAGO_LEASING_ANEXOS',
              ),
              7 => 
              array (
                'name' => 'impago_factoring_cesiones_c',
                'studio' => 'visible',
                'label' => 'LBL_IMPAGO_FACTORING_CESIONES',
              ),
              8 => 
              array (
                'name' => 'impago_cauto_contratos_c',
                'studio' => 'visible',
                'label' => 'LBL_IMPAGO_CAUTO_CONTRATOS',
              ),
              9 => 
              array (
              ),
            ),
          ),
          6 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL5',
            'label' => 'LBL_RECORDVIEW_PANEL5',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'fecha_termino_cto_ca_c',
                'label' => 'LBL_FECHA_TERMINO_CTO_CA_C',
              ),
              1 => 
              array (
                'name' => 'fecha_termino_cto_factor_c',
                'label' => 'LBL_FECHA_TERMINO_CTO_FACTOR_C',
              ),
              2 => 
              array (
                'name' => 'fecha_termino_cto_leasing_c',
                'label' => 'LBL_FECHA_TERMINO_CTO_LEASING_C',
              ),
              3 => 
              array (
              ),
            ),
          ),
          7 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL6',
            'label' => 'LBL_RECORDVIEW_PANEL6',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'vencimiento_seguro_futuro_c',
                'label' => 'LBL_VENCIMIENTO_SEGURO_FUTURO',
              ),
              1 => 
              array (
                'name' => 'vencimiento_seguro_futuro_ca_c',
                'label' => 'LBL_VENCIMIENTO_SEGURO_FUTURO_CA',
              ),
              2 => 
              array (
                'name' => 'vencimiento_seguro_dia_c',
                'label' => 'LBL_VENCIMIENTO_SEGURO_DIA',
              ),
              3 => 
              array (
                'name' => 'vencimiento_seguro_dia_ca_c',
                'label' => 'LBL_VENCIMIENTO_SEGURO_DIA_CA',
              ),
              4 => 
              array (
                'name' => 'vencimiento_seguro_leasing_c',
                'studio' => 'visible',
                'label' => 'LBL_VENCIMIENTO_SEGURO_LEASING',
              ),
              5 => 
              array (
                'name' => 'vencimiento_seguro_ca_c',
                'studio' => 'visible',
                'label' => 'LBL_VENCIMIENTO_SEGURO_CA',
              ),
              6 => 
              array (
                'name' => 'renovacion_seguro_leasing_c',
                'studio' => 'visible',
                'label' => 'LBL_RENOVACION_SEGURO_LEASING',
              ),
              7 => 
              array (
                'name' => 'renovacion_seguro_ca_c',
                'studio' => 'visible',
                'label' => 'LBL_RENOVACION_SEGURO_CA',
              ),
            ),
          ),
          8 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL7',
            'label' => 'LBL_RECORDVIEW_PANEL7',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'vencimiento_anexos_leasing_c',
                'studio' => 'visible',
                'label' => 'LBL_VENCIMIENTO_ANEXOS_LEASING',
              ),
              1 => 
              array (
                'name' => 'ultimo_anexo_leasing_c',
                'label' => 'LBL_ULTIMO_ANEXO_LEASING',
              ),
              2 => 
              array (
                'name' => 'vencimiento_anexos_factoring_c',
                'studio' => 'visible',
                'label' => 'LBL_VENCIMIENTO_ANEXOS_FACTORING',
              ),
              3 => 
              array (
                'name' => 'vencimiento_anexos_ca_c',
                'studio' => 'visible',
                'label' => 'LBL_VENCIMIENTO_ANEXOS_CA',
              ),
            ),
          ),
          9 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL8',
            'label' => 'LBL_RECORDVIEW_PANEL8',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'tct_noticia_general_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_NOTICIA_GENERAL',
              ),
              1 => 
              array (
                'name' => 'tct_noticia_sector_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_NOTICIA_SECTOR',
              ),
              2 => 
              array (
                'name' => 'tct_noticia_region_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_NOTICIA_REGION',
              ),
              3 => 
              array (
              ),
            ),
          ),
          10 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'description',
              ),
              1 => 
              array (
                'name' => 'assigned_user_name',
              ),
              2 => 
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
              3 => 
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
