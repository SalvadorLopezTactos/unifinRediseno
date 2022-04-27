<?php
 // created: 2020-02-25 12:26:30
$dictionary['Lead']['fields']['nombre_c']['labelValue']='Nombre(s)';
$dictionary['Lead']['fields']['nombre_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['nombre_c']['enforced']='';
$dictionary['Lead']['fields']['nombre_c']['dependency']='or(equal($regimen_fiscal_c,"1"),equal($regimen_fiscal_c,"2"))';

 ?>