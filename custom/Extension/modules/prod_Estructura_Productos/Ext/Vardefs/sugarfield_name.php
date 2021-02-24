<?php
 // created: 2021-02-23 13:39:14
$dictionary['prod_Estructura_Productos']['fields']['name']['len']='255';
$dictionary['prod_Estructura_Productos']['fields']['name']['audited']=false;
$dictionary['prod_Estructura_Productos']['fields']['name']['massupdate']=false;
$dictionary['prod_Estructura_Productos']['fields']['name']['importable']='false';
$dictionary['prod_Estructura_Productos']['fields']['name']['duplicate_merge']='disabled';
$dictionary['prod_Estructura_Productos']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['prod_Estructura_Productos']['fields']['name']['merge_filter']='disabled';
$dictionary['prod_Estructura_Productos']['fields']['name']['unified_search']=false;
$dictionary['prod_Estructura_Productos']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['prod_Estructura_Productos']['fields']['name']['calculated']='1';
$dictionary['prod_Estructura_Productos']['fields']['name']['formula']='concat(getDropdownValue("tipo_producto_list",$tipo_producto),"-",getDropdownValue("producto_negocio_list",$negocio),"-",getDropdownValue("producto_financiero_list",$producto_financiero))';
$dictionary['prod_Estructura_Productos']['fields']['name']['enforced']=true;

 ?>