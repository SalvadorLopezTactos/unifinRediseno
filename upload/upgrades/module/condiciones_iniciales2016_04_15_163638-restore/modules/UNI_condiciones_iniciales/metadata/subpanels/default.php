<?php
$module_name = 'UNI_condiciones_iniciales';
$subpanel_layout = 
array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'UNI_condiciones_iniciales',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'name' => 
    array (
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '10%',
      'default' => true,
    ),
    'activo' => 
    array (
      'type' => 'enum',
      'default' => true,
      'studio' => 'visible',
      'vname' => 'LBL_ACTIVO',
      'width' => '10%',
    ),
    'campo_destino_minimo' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_CAMPO_DESTINO_MINIMO',
      'width' => '10%',
      'default' => true,
    ),
    'rango_minimo' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_RANGO_MINIMO',
      'width' => '10%',
      'default' => true,
    ),
    'campo_destino_maximo' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_CAMPO_DESTINO_MAXIMO',
      'width' => '10%',
      'default' => true,
    ),
    'rango_maximo' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_RANGO_MAXIMO',
      'width' => '10%',
      'default' => true,
    ),
    'date_modified' => 
    array (
      'vname' => 'LBL_DATE_MODIFIED',
      'width' => '10%',
      'default' => true,
    ),
    'edit_button' => 
    array (
      'vname' => 'LBL_EDIT_BUTTON',
      'widget_class' => 'SubPanelEditButton',
      'module' => 'UNI_condiciones_iniciales',
      'width' => '4%',
    ),
    'remove_button' => 
    array (
      'vname' => 'LBL_REMOVE',
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'UNI_condiciones_iniciales',
      'width' => '5%',
    ),
  ),
);
