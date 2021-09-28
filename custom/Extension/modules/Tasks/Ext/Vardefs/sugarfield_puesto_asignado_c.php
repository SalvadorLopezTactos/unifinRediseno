<?php
 // created: 2021-09-27 11:43:43
$dictionary['Task']['fields']['puesto_asignado_c']['duplicate_merge_dom_value']=0;
$dictionary['Task']['fields']['puesto_asignado_c']['labelValue']='Puesto Asignado';
$dictionary['Task']['fields']['puesto_asignado_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Task']['fields']['puesto_asignado_c']['calculated']='true';
$dictionary['Task']['fields']['puesto_asignado_c']['formula']='related($assigned_user_link,"puestousuario_c")';
$dictionary['Task']['fields']['puesto_asignado_c']['enforced']='true';
$dictionary['Task']['fields']['puesto_asignado_c']['dependency']='';

 ?>