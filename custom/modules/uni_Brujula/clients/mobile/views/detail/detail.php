<?php
$module_name = 'uni_Brujula';
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
              0 => 'DELETE',
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
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 'name',
              1 => 'assigned_user_name',
              2 => 
              array (
                'name' => 'fecha_reporte',
                'label' => 'LBL_FECHA_REPORTE',
              ),
              3 => 
              array (
                'name' => 'vacaciones_c',
                'label' => 'LBL_VACACIONES',
              ),
              4 => 
              array (
                'name' => 'contactos_numero',
                'label' => 'LBL_CONTACTOS_NUMERO',
              ),
              5 => 
              array (
                'name' => 'contactos_duracion',
                'label' => 'LBL_CONTACTOS_DURACION',
              ),
              6 => 
              array (
                'name' => 'contactos_no_localizados',
                'label' => 'LBL_CONTACTOS_NO_LOCALIZADOS',
              ),
              7 => 
              array (
                'name' => 'contactos_no_interesados',
                'label' => 'LBL_CONTACTOS_NO_INTERESADOS',
              ),
              8 => 
              array (
                'name' => 'contactos_seguimiento_futuro',
                'label' => 'LBL_CONTACTOS_SEGUIMIENTO_FUTURO',
              ),
              9 => 
              array (
                'name' => 'contactos_siguiente_llamada',
                'label' => 'LBL_CONTACTOS_SIGUIENTE_LLAMADA',
              ),
              10 => 
              array (
                'name' => 'contactos_por_visitar',
                'label' => 'LBL_CONTACTOS_POR_VISITAR',
              ),
              11 => 
              array (
                'name' => 'contactos_enviaran_informacion',
                'label' => 'LBL_CONTACTOS_ENVIARAN_INFORMACION',
              ),
              12 => 
              array (
                'name' => 'tiempo_prospeccion',
                'label' => 'LBL_TIEMPO_PROSPECCION',
              ),
              13 => 
              array (
                'name' => 'tiempo_revision_expediente_c',
                'label' => 'LBL_TIEMPO_REVISION_EXPEDIENTE_C',
              ),
              14 => 
              array (
                'name' => 'tiempo_armado_expedientes',
                'label' => 'LBL_TIEMPO_ARMADO_EXPEDIENTES',
              ),
              15 => 
              array (
                'name' => 'tiempo_seguimiento_expedientes',
                'label' => 'LBL_TIEMPO_SEGUIMIENTO_EXPEDIENTES',
              ),
              16 => 
              array (
                'name' => 'tiempo_operacion',
                'label' => 'LBL_TIEMPO_OPERACION',
              ),
              17 => 
              array (
                'name' => 'tiempo_liberacion',
                'label' => 'LBL_TIEMPO_LIBERACION',
              ),
              18 => 
              array (
                'name' => 'tiempo_servicio_cliente',
                'label' => 'LBL_TIEMPO_SERVICIO_CLIENTE',
              ),
              19 => 
              array (
                'name' => 'tiempo_otras_actividades',
                'label' => 'LBL_TIEMPO_OTRAS_ACTIVIDADES',
              ),
              20 => 
              array (
                'name' => 'porcentaje_prospeccion',
                'label' => 'LBL_PORCENTAJE_PROSPECCION',
              ),
              21 => 
              array (
                'name' => 'porcentaje_revision_exp_c',
                'label' => 'LBL_PORCENTAJE_REVISION_EXP_C',
              ),
              22 => 
              array (
                'name' => 'porcentaje_armado_expedientes',
                'label' => 'LBL_PORCENTAJE_ARMADO_EXPEDIENTES',
              ),
              23 => 
              array (
                'name' => 'porcentaje_seguimiento_expedie',
                'label' => 'LBL_PORCENTAJE_SEGUIMIENTO_EXPEDIE',
              ),
              24 => 
              array (
                'name' => 'porcentaje_operacion',
                'label' => 'LBL_PORCENTAJE_OPERACION',
              ),
              25 => 
              array (
                'name' => 'porcentaje_liberacion',
                'label' => 'LBL_PORCENTAJE_LIBERACION',
              ),
              26 => 
              array (
                'name' => 'porcentaje_servicio_cliente',
                'label' => 'LBL_PORCENTAJE_SERVICIO_CLIENTE',
              ),
              27 => 
              array (
                'name' => 'porcentaje_otras_actividades',
                'label' => 'LBL_PORCENTAJE_OTRAS_ACTIVIDADES',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
