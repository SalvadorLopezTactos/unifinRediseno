<?php
$viewdefs['Prospects'] = 
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
                'event' => 'button:convert_button:click',
                'name' => 'convert_button',
                'label' => 'LBL_CONVERT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'manage-subscription',
                'name' => 'manage_subscription_button',
                'label' => 'LBL_MANAGE_SUBSCRIPTIONS',
              ),
              7 => 
              array (
                'type' => 'vcard',
                'name' => 'vcard_button',
                'label' => 'LBL_VCARD_DOWNLOAD',
                'acl_action' => 'edit',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              10 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'Prospects',
                'acl_action' => 'create',
              ),
              11 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:historical_summary_button:click',
                'name' => 'historical_summary_button',
                'label' => 'LBL_HISTORICAL_SUMMARY',
                'acl_action' => 'view',
              ),
              12 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              13 => 
              array (
                'type' => 'divider',
              ),
              14 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
              15 => 
              array (
                'name' => 'send_survey',
                'type' => 'rowaction',
                'label' => 'Send Survey',
                'acl_action' => 'send_survey',
                'event' => 'button:send_survey:click',
              ),
              16 => 
              array (
                'name' => 'send_poll',
                'type' => 'rowaction',
                'label' => 'Send Poll',
                'acl_action' => 'send_poll',
                'event' => 'button:send_poll:click',
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
              ),
              1 => 
              array (
                'name' => 'name',
                'type' => 'fullname',
                'label' => 'LBL_NAME',
                'dismiss_label' => true,
                'fields' => 
                array (
                  0 => 'salutation',
                  1 => 'first_name',
                  2 => 'last_name',
                ),
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
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labels' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'readonly' => false,
                'name' => 'estatus_po_c',
                'label' => 'LBL_ESTATUS_PO',
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'subestatus_po_c',
                'label' => 'LBL_SUBESTATUS_PO',
              ),
              2 => 
              array (
                'readonly' => false,
                'name' => 'detalle_subestatus_po_c',
                'label' => 'LBL_DETALLE_SUBESTATUS_PO',
              ),
              3 => 
              array (
              ),
              4 => 
              array (
                'readonly' => false,
                'name' => 'regimen_fiscal_c',
                'label' => 'LBL_REGIMEN_FISCAL_C',
              ),
              5 => 
              array (
                'readonly' => false,
                'name' => 'nombre_empresa_c',
                'label' => 'LBL_NOMBRE_EMPRESA_C',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'nombre_c',
                'label' => 'LBL_NOMBRE_C',
              ),
              7 => 
              array (
                'readonly' => false,
                'name' => 'apellido_paterno_c',
                'label' => 'LBL_APELLIDO_PATERNO_C',
              ),
              8 => 
              array (
                'readonly' => false,
                'name' => 'apellido_materno_c',
                'label' => 'LBL_APELLIDO_MATERNO_C',
              ),
              9 => 
              array (
                'readonly' => false,
                'name' => 'genero_c',
                'label' => 'LBL_GENERO',
              ),
              10 => 
              array (
                'readonly' => false,
                'name' => 'puesto_c',
                'label' => 'LBL_PUESTO_C',
              ),
              11 => 
              array (
              ),
              12 => 
              array (
                'readonly' => false,
                'name' => 'origen_c',
                'label' => 'LBL_ORIGEN_C',
              ),
              13 => 
              array (
                'readonly' => false,
                'name' => 'detalle_origen_c',
                'label' => 'LBL_DETALLE_ORIGEN_C',
              ),
              14 => 
              array (
                'readonly' => false,
                'name' => 'prospeccion_propia_c',
                'label' => 'LBL_PROSPECCION_PROPIA',
              ),
              15 => 
              array (
              ),
              16 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => false,
                'name' => 'ventas_anuales_c',
                'label' => 'LBL_VENTAS_ANUALES_C',
              ),
              17 => 
              array (
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => false,
                'name' => 'potencial_lead_c',
                'label' => 'LBL_POTENCIAL_LEAD_C',
              ),
              18 => 
              array (
                'readonly' => false,
                'name' => 'rfc_c',
                'label' => 'LBL_RFC',
              ),
              19 => 
              array (
                'readonly' => false,
                'name' => 'zona_geografica_c',
                'label' => 'LBL_ZONA_GEOGRAFICA_C',
              ),
              20 => 
              array (
                'name' => 'email',
              ),
              21 => 
              array (
              ),
              22 => 
              array (
                'name' => 'prospects_telefonos',
                'studio' => 'visible',
                'label' => 'LBL_PROSPECTS_TELEFONOS',
                'span' => 12,
              ),
              23 => 
              array (
              ),
              24 => 
              array (
              ),
              25 => 'assigned_user_name',
              26 => 
              array (
                'readonly' => false,
                'name' => 'fecha_asignacion_c',
                'label' => 'LBL_FECHA_ASIGNACION',
              ),
              27 => 
              array (
                'readonly' => false,
                'name' => 'contacto_asociado_c',
                'label' => 'LBL_CONTACTO_ASOCIADO',
              ),
              28 => 
              array (
              ),
              29 => 
              array (
                'name' => 'account_name',
              ),
              30 => 
              array (
              ),
              31 => 
              array (
                'name' => 'prospects_prospects_1_name',
              ),
              32 => 
              array (
              ),
            ),
          ),
          2 => 
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
                'name' => 'prospects_clasf_sectorial',
                'studio' => 'visible',
                'label' => 'LBL_PROSPECTS_CLASF_SECTORIAL',
                'span' => 12,
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
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'prospects_direcciones',
                'studio' => 'visible',
                'label' => 'LBL_PROSPECTS_DIRECCIONES',
                'span' => 12,
              ),
            ),
          ),
          4 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
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
                'related_fields' => 
                array (
                  0 => 'lead_id',
                ),
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
              3 => 'team_name',
              4 => 
              array (
                'name' => 'tct_link_personalizado_txf_c',
                'studio' => 'visible',
                'label' => 'LBL_TCT_LINK_PERSONALIZADO_TXF',
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
