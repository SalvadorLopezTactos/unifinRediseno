<?php
 // created: 2018-05-22 10:34:12
$dictionary['Meeting']['fields']['direccion_country_c']['labelValue']='LBL_DIRECCION_COUNTRY';
$dictionary['Meeting']['fields']['direccion_country_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Meeting']['fields']['direccion_country_c']['group']='direccion_c';
$dictionary['Meeting']['fields']['direccion_country_c']['formula']='related($created_by_link,"first_name")';
$dictionary['Meeting']['fields']['direccion_country_c']['enforced']='false';
$dictionary['Meeting']['fields']['direccion_country_c']['dependency']='';

 ?>