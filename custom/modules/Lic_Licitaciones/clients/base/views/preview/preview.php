<?php
$module_name = 'Lic_Licitaciones';
$viewdefs[$module_name] = 
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
                'name' => 'cuenta',
                'studio' => 'visible',
                'label' => 'LBL_CUENTA',
              ),
              1 => 
              array (
                'name' => 'monto_total',
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'label' => 'LBL_MONTO_TOTAL',
              ),
              2 => 
              array (
                'name' => 'region',
                'label' => 'LBL_REGION',
              ),
              3 => 
              array (
                'name' => 'equipo',
                'label' => 'LBL_EQUIPO',
              ),
              4 => 
              array (
                'name' => 'fecha_ultimo_contacto',
                'label' => 'LBL_FECHA_ULTIMO_CONTACTO',
              ),
              5 => 
              array (
                'name' => 'descripcion_contrato',
                'studio' => 'visible',
                'label' => 'LBL_DESCRIPCION_CONTRATO',
              ),
              6 => 
              array (
                'name' => 'institucion',
                'label' => 'LBL_INSTITUCION',
                'span' => 12,
              ),
              7 => 
              array (
                'name' => 'fecha_publicacion',
                'label' => 'LBL_FECHA_PUBLICACION',
              ),
              8 => 
              array (
                'name' => 'fecha_apertura',
                'label' => 'LBL_FECHA_APERTURA',
              ),
              9 => 
              array (
                'name' => 'fecha_inicio_contrato',
                'label' => 'LBL_FECHA_INICIO_CONTRATO',
              ),
              10 => 
              array (
                'name' => 'fecha_fin_contrato',
                'label' => 'LBL_FECHA_FIN_CONTRATO',
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
