<?php
$module_name = 'Val_Validaciones';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'detail' => 
      array (
        'templateMeta' => 
        array (
          'form' => 
          array (
            'buttons' => 
            array (
              0 => 'EDIT',
              1 => 'DUPLICATE',
              2 => 'DELETE',
            ),
          ),
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
          'useTabs' => false,
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 'name',
              1 => 'assigned_user_name',
              2 => 
              array (
                'name' => 'modulo',
                'studio' => 'visible',
                'label' => 'LBL_MODULO',
              ),
              3 => 
              array (
                'name' => 'estatus',
                'studio' => 'visible',
                'label' => 'LBL_ESTATUS',
              ),
              4 => 
              array (
                'name' => 'campo_padre',
                'label' => 'LBL_CAMPO_PADRE',
              ),
              5 => 
              array (
                'name' => 'campo_dependiente',
                'label' => 'LBL_CAMPO_DEPENDIENTE',
              ),
              6 => 
              array (
                'name' => 'criterio_validacion',
                'label' => 'LBL_CRITERIO_VALIDACION',
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'comment' => 'Date record created',
                'studio' => 
                array (
                  'portaleditview' => false,
                ),
                'readonly' => true,
                'label' => 'LBL_DATE_ENTERED',
              ),
              8 => 
              array (
                'name' => 'visible',
                'label' => 'LBL_VISIBLE',
              ),
              9 => 
              array (
                'name' => 'requerido',
                'label' => 'LBL_REQUERIDO',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
