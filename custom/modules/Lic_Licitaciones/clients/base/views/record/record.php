<?php
$module_name = 'Lic_Licitaciones';
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
            'name' => 'create_meet',
            'label' => '+ Reunión',
            'css_class' => 'btn-danger',
            'showOn' => 'view',
            'events' =>
            array (
              'click' => 'button:btn_meet_button:click',
            ),
          ),
          1 =>
          array (
            'type' => 'button',
            'name' => 'create_call',
            'label' => '+ Llamada',
            'css_class' => 'btn-success',
            'showOn' => 'view',
            'events' =>
            array (
              'click' => 'button:btn_call_button:click',
            ),
          ),
          2 =>
          array (
            'type' => 'button',
            'name' => 'create_pre',
            'label' => '+ Pre-solicitud',
            'css_class' => 'btn',
            'showOn' => 'view',
            'events' =>
            array (
              'click' => 'button:btn_pre_button:click',
            ),
          ),
          3 =>
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
          4 =>
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          5 =>
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
                'acl_module' => 'Lic_Licitaciones',
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
              1 => array (
              'name' => 'name',
              ),
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
                'name' => 'lic_licitaciones_accounts_name',
              ),
              1 =>
              array (
                'name' => 'monto_total',
                'label' => 'LBL_MONTO_TOTAL',
                'inline' => true,
                'type' => 'fieldset',
                'fields' =>
                array (
                  0 =>
                  array (
                    'name' => 'divisa_c',
                  ),
                  1 =>
                  array (
                    'name' => 'monto_total',
                  ),
                ),
              ),
              2 =>
              array (
                'name' => 'leads_lic_licitaciones_1_name',
              ),
              3 =>
              array (
              ),
              4 =>
              array (
                'name' => 'region',
                'label' => 'LBL_REGION',
              ),
              5 =>
              array (
                'name' => 'equipo',
                'label' => 'LBL_EQUIPO',
              ),
              6 =>
              array (
                'name' => 'fecha_ultimo_contacto',
                'label' => 'LBL_FECHA_ULTIMO_CONTACTO',
              ),
              7 =>
              array (
                'name' => 'descripcion_contrato',
                'studio' => 'visible',
                'label' => 'LBL_DESCRIPCION_CONTRATO',
              ),
              8 =>
              array (
                'name' => 'institucion',
                'label' => 'LBL_INSTITUCION',
                'span' => 12,
              ),
              9 =>
              array (
                'name' => 'fecha_publicacion',
                'label' => 'LBL_FECHA_PUBLICACION',
              ),
              10 =>
              array (
                'name' => 'fecha_apertura',
                'label' => 'LBL_FECHA_APERTURA',
              ),
              11 =>
              array (
                'name' => 'fecha_inicio_contrato',
                'label' => 'LBL_FECHA_INICIO_CONTRATO',
              ),
              12 =>
              array (
                'name' => 'fecha_fin_contrato',
                'label' => 'LBL_FECHA_FIN_CONTRATO',
              ),
              13 =>
              array (
                'name' => 'assigned_user_name',
                'span' => 12,
              ),
              14 =>
              array (
                'name' => 'resultado_licitacion_c',
                'label' => 'LBL_RESULTADO_LICITACION',
              ),
              15 =>
              array (
                'name' => 'razon_no_viable_c',
                'label' => 'LBL_RAZON_NO_VIABLE',
              ),
              16 =>
              array (
                'name' => 'codigo_contrato_c',
                'label' => 'LBL_CODIGO_CONTRATO',
              ),
              17 =>
              array (
                'name' => 'url_contrato_c',
                'label' => 'LBL_URL_CONTRATO',
              ),
              18 =>
              array (
              ),
              19 =>
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
