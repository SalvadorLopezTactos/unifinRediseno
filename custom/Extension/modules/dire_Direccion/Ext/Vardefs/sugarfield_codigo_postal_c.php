<?php
 // created: 2022-04-27 21:26:09
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['duplicate_merge_dom_value']=0;
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['labelValue']='Código Postal';
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['calculated']='true';
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['formula']='related($dir_sepomex_dire_direccion,"codigo_postal")';
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['enforced']='true';
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['dependency']='';
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['required_formula']='';
$dictionary['dire_Direccion']['fields']['codigo_postal_c']['readonly_formula']='';

 ?>