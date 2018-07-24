<?php
$viewdefs['Opportunities'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'create' => 
      array (
		    'template' => 'record',
        'buttons' => 
        array(
          0 => 
          array(
      			'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'events' => array(
                'click' => 'button:cancel_button:click',
            ),
		      ),
          1 =>
          array(
            'name' => 'save_button',
            'type' => 'button',
            'primary' => true,
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'events' => array(
                'click' => 'button:save_button:click',
            ),
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
                'related_fields' => 
                array (
                  0 => 'total_revenue_line_items',
                  1 => 'closed_revenue_line_items',
                  2 => 'included_revenue_line_items',
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
                'name' => 'tct_etapa_ddw_c',
                'label' => 'LBL_TCT_ETAPA_DDW_C',
              ),
              1 => 
              array (
                'name' => 'estatus_c',
                'studio' => 'visible',
                'label' => 'LBL_ESTATUS',
              ),
              2 => 
              array (
                'name' => 'idsolicitud_c',
                'label' => 'LBL_IDSOLICITUD',
              ),
              3 => 
              array (
                'name' => 'id_process_c',
                'label' => 'LBL_ID_PROCESS',
              ),
              4 => 
              array (
                'name' => 'account_name',
                'related_fields' => 
                array (
                  0 => 'account_id',
                ),
              ),
              5 => 
              array (
                'name' => 'tipo_producto_c',
                'studio' => 'visible',
                'label' => 'LBL_TIPO_PRODUCTO',
              ),
              6 => 
              array (
                'name' => 'monto_c',
                'studio' => 'visible',
                'label' => 'LBL_MONTO',
              ),
              7 => 
              array (
                'name' => 'assigned_user_name',
                'studio' => 'visible',
                'label' => 'LBL_ASSIGNED_TO',
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
