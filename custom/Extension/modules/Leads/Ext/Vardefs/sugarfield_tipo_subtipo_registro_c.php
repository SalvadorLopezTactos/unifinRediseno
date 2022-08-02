<?php
 // created: 2020-05-05 20:39:37
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['duplicate_merge_dom_value']=0;
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['labelValue']='Tipo y Subtipo de Lead';
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['calculated']='1';
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['formula']='ifElse(	equal($tipo_registro_c,"Persona"),	"PERSONA",	ifElse(		equal($tipo_registro_c,"Proveedor"),		"PROVEEDOR",		strToUpper(concat(getDropdownValue("tipo_registro_cuenta_list",$tipo_registro_c)," ",getDropdownValue("subtipo_registro_cuenta_list",$subtipo_registro_c)))	))';
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['enforced']='1';
$dictionary['Lead']['fields']['tipo_subtipo_registro_c']['dependency']='';

 ?>