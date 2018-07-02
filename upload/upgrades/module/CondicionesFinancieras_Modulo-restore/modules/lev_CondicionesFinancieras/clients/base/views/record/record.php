<?php
$module_name = 'lev_CondicionesFinancieras';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
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
                'name' => 'lev_condicionesfinancieras_opportunities_name',
              ),
              1 => 
              array (
                'name' => 'assigned_user_name',
              ),
              2 => 
              array (
                'name' => 'incremento_ratificacion',
                'label' => 'LBL_INCREMENTO_RATIFICACION',
              ),
              3 => 
              array (
              ),
              4 => 
              array (
                'name' => 'idsolicitud',
                'label' => 'LBL_IDSOLICITUD',
              ),
              5 => 
              array (
                'name' => 'idactivo',
                'studio' => 'visible',
                'label' => 'LBL_IDACTIVO',
              ),
              6 => 
              array (
                'name' => 'plazo',
                'studio' => 'visible',
                'label' => 'LBL_PLAZO',
              ),
              7 => 
              array (
                'name' => 'deposito_en_garantia',
                'label' => 'LBL_DEPOSITO_EN_GARANTIA',
              ),
              8 => 
              array (
                'name' => 'tasa_minima',
                'label' => 'LBL_TASA_MINIMA',
              ),
              9 => 
              array (
                'name' => 'tasa_maxima',
                'label' => 'LBL_TASA_MAXIMA',
              ),
              10 => 
              array (
                'name' => 'vrc_minimo',
                'label' => 'LBL_VRC_MINIMO',
              ),
              11 => 
              array (
                'name' => 'vrc_maximo',
                'label' => 'LBL_VRC_MAXIMO',
              ),
              12 => 
              array (
                'name' => 'vri_minimo',
                'label' => 'LBL_VRI_MINIMO',
              ),
              13 => 
              array (
                'name' => 'vri_maximo',
                'label' => 'LBL_VRI_MAXIMO',
              ),
              14 => 
              array (
                'name' => 'comision_minima',
                'label' => 'LBL_COMISION_MINIMA',
              ),
              15 => 
              array (
                'name' => 'comision_maxima',
                'label' => 'LBL_COMISION_MAXIMA',
              ),
              16 => 
              array (
                'name' => 'renta_inicial_minima',
                'label' => 'LBL_RENTA_INICIAL_MINIMA',
              ),
              17 => 
              array (
                'name' => 'renta_inicial_maxima',
                'label' => 'LBL_RENTA_INICIAL_MAXIMA',
              ),
              18 => 
              array (
                'name' => 'uso_particular',
                'label' => 'LBL_USO_PARTICULAR',
              ),
              19 => 
              array (
                'name' => 'uso_empresarial',
                'label' => 'LBL_USO_EMPRESARIAL',
              ),
              20 => 
              array (
                'name' => 'activo_nuevo',
                'label' => 'LBL_ACTIVO_NUEVO',
              ),
              21 => 
              array (
                'name' => 'activo_usado',
                'label' => 'LBL_ACTIVO_USADO',
              ),
              22 => 
              array (
                'name' => 'plazo_minimo',
                'label' => 'LBL_PLAZO_MINIMO',
              ),
              23 => 
              array (
                'name' => 'plazo_maximo',
                'label' => 'LBL_PLAZO_MAXIMO',
              ),
            ),
          ),
          2 => 
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
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
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
