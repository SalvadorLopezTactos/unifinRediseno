<?php
$module_name = 'Ref_Venta_Cruzada';
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
                'acl_module' => 'Ref_Venta_Cruzada',
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
                'name' => 'estatus',
                'label' => 'LBL_ESTATUS',
              ),
              1 => 
              array (
                'name' => 'accounts_ref_venta_cruzada_1_name',
              ),
              2 => 
              array (
                'name' => 'description',
                'span' => 6,
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
                'span' => 6,
              ),
              4 => 
              array (
                'name' => 'assigned_user_name',
              ),
              5 => 
              array (
                'name' => 'producto_origen',
                'label' => 'LBL_PRODUCTO_ORIGEN',
              ),
              6 => 
              array (
                'name' => 'usuario_producto',
                'studio' => 'visible',
                'label' => 'LBL_USUARIO_PRODUCTO',
              ),
              7 => 
              array (
                'name' => 'producto_referenciado',
                'label' => 'LBL_PRODUCTO_REFERENCIADO',
              ),
              8 => 
              array (
                'name' => 'usuario_rm',
                'studio' => 'visible',
                'label' => 'LBL_USUARIO_RM',
              ),
              9 => 
              array (
              ),
              10 => 
              array (
                'name' => 'primer_fecha_anexo',
                'label' => 'LBL_PRIMER_FECHA_ANEXO',
                'readonly' => true,
              ),
              11 => 
              array (
                'name' => 'ultima_fecha_anexo',
                'label' => 'LBL_ULTIMA_FECHA_ANEXO',
                'readonly' => true,
              ),
              12 => 
              array (
                'name' => 'numero_anexos',
                'label' => 'LBL_NUMERO_ANEXOS',
                'readonly' => true,
              ),
              13 => 
              array (
              ),
              14 => 
              array (
                'name' => 'cancelado',
                'label' => 'LBL_CANCELADO',
              ),
              15 => 
              array (
              ),
              16 => 
              array (
                'name' => 'avance_cliente',
                'label' => 'LBL_AVANCE_CLIENTE',
              ),
              17 => 
              array (
                'name' => 'usuario_rechazo',
                'studio' => 'visible',
                'label' => 'LBL_USUARIO_RECHAZO',
              ),
              18 => 
              array (
                'name' => 'motivo_rechazo',
                'label' => 'LBL_MOTIVO_RECHAZO',
              ),
              19 => 
              array (
                'name' => 'explicacion_rechazo',
                'studio' => 'visible',
                'label' => 'LBL_EXPLICACION_RECHAZO',
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
