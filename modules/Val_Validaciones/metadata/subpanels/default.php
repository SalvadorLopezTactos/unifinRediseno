<?php
$module_name = 'Val_Validaciones';
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
      'popup_module' => 'Val_Validaciones',
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
    'modulo' => 
    array (
      'type' => 'enum',
      'studio' => 'visible',
      'vname' => 'LBL_MODULO',
      'width' => '10%',
      'default' => true,
    ),
    'campo_dependiente' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_CAMPO_DEPENDIENTE',
      'width' => '10%',
      'default' => true,
    ),
    'campo_padre' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_CAMPO_PADRE',
      'width' => '10%',
      'default' => true,
    ),
    'criterio_validacion' => 
    array (
      'type' => 'varchar',
      'vname' => 'LBL_CRITERIO_VALIDACION',
      'width' => '10%',
      'default' => true,
    ),
    'visible' => 
    array (
      'type' => 'bool',
      'vname' => 'LBL_VISIBLE',
      'width' => '10%',
      'default' => true,
    ),
    'estatus' => 
    array (
      'type' => 'enum',
      'default' => true,
      'studio' => 'visible',
      'vname' => 'LBL_ESTATUS',
      'width' => '10%',
    ),
    'edit_button' => 
    array (
      'vname' => 'LBL_EDIT_BUTTON',
      'widget_class' => 'SubPanelEditButton',
      'module' => 'Val_Validaciones',
      'width' => '4%',
    ),
    'remove_button' => 
    array (
      'vname' => 'LBL_REMOVE',
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'Val_Validaciones',
      'width' => '5%',
    ),
  ),
);
