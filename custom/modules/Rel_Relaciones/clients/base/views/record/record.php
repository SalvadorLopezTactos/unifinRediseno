<?php
$viewdefs['Rel_Relaciones'] = 
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
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'Eliminar todas las relaciones',
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
                'name' => 'rel_relaciones_accounts_1_name',
                'readonly' => true,
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'relaciones_activas',
                'studio' => 'visible',
                'label' => 'LBL_RELACIONES_ACTIVAS',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'relacion_c',
                'studio' => 'visible',
                'label' => 'LBL_RELACION',
                'span' => 12,
              ),
              4 => 
              array (
                'name' => 'tct_validado_juridico_chk_c',
                'label' => 'LBL_TCT_VALIDADO_JURIDICO_CHK',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'miembrodecomite',
                'label' => 'LBL_MIEMBRODECOMITE',
                'span' => 12,
              ),
              7 => 
              array (
                'name' => 'porcentaje_participacion_c',
                'label' => 'LBL_PORCENTAJE_PARTICIPACION',
              ),
              8 => 
              array (
                'name' => 'montodeparticipacion',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_MONTODEPARTICIPACION',
              ),
              9 => 
              array (
                'name' => 'tipodecontacto',
                'studio' => 'visible',
                'label' => 'LBL_TIPODECONTACTO',
                'span' => 12,
              ),
              10 => 
              array (
                'name' => 'parentesco',
                'studio' => 'visible',
                'label' => 'LBL_PARENTESCO',
                'span' => 12,
              ),
              11 => 
              array (
                'name' => 'limitedecredito',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LIMITEDECREDITO',
              ),
              12 => 
              array (
                'name' => 'plazoendias',
                'label' => 'LBL_PLAZOENDIAS',
              ),
              13 => 
              array (
                'name' => 'tiempodeconocerloano',
                'label' => 'LBL_TIEMPODECONOCERLOANO',
              ),
              14 => 
              array (
                'name' => 'tiempodeconocerlomeses',
                'label' => 'LBL_TIEMPODECONOCERLOMESES',
              ),
              15 => 
              array (
                'name' => 'probabilidadincremento',
                'label' => 'LBL_PROBABILIDADINCREMENTO',
              ),
              16 => 
              array (
                'name' => 'facturacionmensual',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_FACTURACIONMENSUAL',
              ),
              17 => 
              array (
                'name' => 'opinion',
                'studio' => 'visible',
                'label' => 'LBL_OPINION',
              ),
              18 => 
              array (
                'name' => 'consumomensual',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_CONSUMOMENSUAL',
              ),
              19 => 
              array (
                'name' => 'linea',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_LINEA',
              ),
              20 => 
              array (
                'name' => 'saldo',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_SALDO',
              ),
              21 => 
              array (
                'name' => 'producto',
                'label' => 'LBL_PRODUCTO',
              ),
              22 => 
              array (
              ),
              23 => 
              array (
                'name' => 'puesto',
                'label' => 'LBL_PUESTO',
              ),
              24 => 
              array (
                'name' => 'puestodescription',
                'studio' => 'visible',
                'label' => 'LBL_PUESTODESCRIPTION',
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'relaciones_producto',
                'studio' => 'visible',
                'label' => 'LBL_RELACIONES_PRODUCTO',
                'span' => 12,
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
