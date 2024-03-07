<?php
$viewdefs['Cases'] = 
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
                'primary' => true,
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
                'name' => 'create_button',
                'type' => 'rowaction',
                'event' => 'button:create_article_button:click',
                'label' => 'LBL_CREATE_KB_DOCUMENT',
                'acl_module' => 'KBContents',
                'acl_action' => 'create',
              ),
              6 => 
              array (
                'type' => 'divider',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              8 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'Cases',
                'acl_action' => 'create',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:historical_summary_button:click',
                'name' => 'historical_summary_button',
                'label' => 'LBL_HISTORICAL_SUMMARY',
                'acl_action' => 'view',
              ),
              10 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              11 => 
              array (
                'type' => 'divider',
              ),
              12 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
              13 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:finalizar_ticket:click',
                'name' => 'finalizar_ticket',
                'label' => 'Finalizar Caso',
                'acl_action' => 'view',
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
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
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
                'readonly' => true,
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
                'name' => 'leads_cases_1_name',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'readonly' => false,
                'name' => 'vip_c',
                'label' => 'LBL_VIP',
                'span' => 12,
              ),
              9 => 
              array (
                'readonly' => false,
                'name' => 'producto_c',
                'label' => 'LBL_PRODUCTO',
              ),
              10 => 'type',
              11 => 
              array (
                'readonly' => false,
                'name' => 'solicitud_c',
                'studio' => 'visible',
                'label' => 'LBL_SOLICITUD',
                'initial_filter' => 'filterOppsRelatedToAccount',
                'initial_filter_label' => 'LBL_FILTER_OPPS_RELATED_TO_ACCOUNT',
                'filter_populate' =>
                array(
                  'estatus_c' =>
                  array(
                    0 => 'K',
                  ),
                ),
                'filter_relate' =>
                array(
                  'account_id' => 'account_id',
                ),
              ),
              12 => 
              array (
              ),
              13 => 
              array (
                'readonly' => false,
                'name' => 'subtipo_c',
                'label' => 'LBL_SUBTIPO',
              ),
              14 => 
              array (
                'readonly' => false,
                'name' => 'detalle_subtipo_c',
                'label' => 'LBL_DETALLE_SUBTIPO',
              ),
              15 => 'priority',
              16 => 'status',
              17 => 
              array (
                'name' => 'source',
              ),
              18 => 
              array (
              ),
              19 => 
              array (
                'readonly' => false,
                'name' => 'tipo_seguimiento_c',
                'label' => 'LBL_TIPO_SEGUIMIENTO',
              ),
              20 => 
              array (
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
              4 => 
              array (
                'readonly' => false,
                'name' => 'valida_cambio_fiscal_c',
                'label' => 'LBL_VALIDA_CAMBIO_FISCAL',
              ),
              5 => 
              array (
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
