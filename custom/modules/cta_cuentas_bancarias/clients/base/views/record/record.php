<?php
$module_name = 'cta_cuentas_bancarias';
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
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
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
                'name' => 'banco',
                'label' => 'LBL_BANCO',
              ),
              1 => 
              array (
                'name' => 'estado',
                'label' => 'LBL_ESTADO',
              ),
              2 => 
              array (
                'name' => 'cuenta',
                'label' => 'LBL_CUENTA',
              ),
              3 => 
              array (
                'name' => 'clabe',
                'label' => 'LBL_CLABE',
              ),
              4 => 
              array (
                'name' => 'plaza',
                'label' => 'LBL_PLAZA',
              ),
              5 => 
              array (
                'name' => 'sucursal',
                'label' => 'LBL_SUCURSAL',
              ),
              6 => 
              array (
                'name' => 'usos',
                'label' => 'LBL_USOS',
              ),
              7 => 
              array (
                'name' => 'idcorto_c',
                'label' => 'LBL_IDCORTO_C',
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
                'readonly' => false,
                'name' => 'divisa_c',
                'label' => 'LBL_DIVISA',
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'tipo_clave_c',
                'label' => 'LBL_TIPO_CLAVE',
              ),
              2 => 
              array (
                'readonly' => false,
                'name' => 'forma_pago_c',
                'label' => 'LBL_FORMA_PAGO',
              ),
              3 => 
              array (
                'readonly' => false,
                'name' => 'regimen_cuenta_c',
                'label' => 'LBL_REGIMEN_CUENTA',
              ),
              4 => 
              array (
                'readonly' => false,
                'name' => 'tipo_cuenta_c',
                'label' => 'LBL_TIPO_CUENTA',
              ),
              5 => 
              array (
                'readonly' => false,
                'name' => 'convenio_c',
                'label' => 'LBL_CONVENIO',
              ),
              6 => 
              array (
                'readonly' => false,
                'name' => 'domiciliacion_c',
                'label' => 'LBL_DOMICILIACION',
              ),
              7 => 
              array (
              ),
            ),
          ),
          3 => 
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
                'name' => 'cta_cuentas_bancarias_accounts_name',
                'span' => 12,
              ),
              1 => 
              array (
                'readonly' => false,
                'name' => 'validada_c',
                'label' => 'LBL_VALIDADA',
              ),
              2 => 
              array (
                'readonly' => false,
                'name' => 'vigencia_c',
                'label' => 'LBL_VIGENCIA',
              ),
              3 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
              4 => 
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
              5 => 
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
