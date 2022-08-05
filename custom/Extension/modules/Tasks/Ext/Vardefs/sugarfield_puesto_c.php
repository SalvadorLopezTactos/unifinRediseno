<?php
 // created: 2021-10-05 09:55:02
$dictionary['Task']['fields']['puesto_c']['duplicate_merge_dom_value']=0;
$dictionary['Task']['fields']['puesto_c']['labelValue']='Puesto Creado';
$dictionary['Task']['fields']['puesto_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Task']['fields']['puesto_c']['calculated']='1';
$dictionary['Task']['fields']['puesto_c']['formula']='related($created_by_link,"puestousuario_c")';
$dictionary['Task']['fields']['puesto_c']['enforced']='1';
$dictionary['Task']['fields']['puesto_c']['dependency']='';

 ?>