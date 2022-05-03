<?php
 // created: 2022-04-29 17:24:42
$dictionary['Prospect']['fields']['nombre_c']['labelValue']='Nombre';
$dictionary['Prospect']['fields']['nombre_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['nombre_c']['enforced']='';
$dictionary['Prospect']['fields']['nombre_c']['dependency']='not(equal($regimen_fiscal_c,"3"))';
$dictionary['Prospect']['fields']['nombre_c']['required_formula']='not(equal($regimen_fiscal_c,"3"))';
$dictionary['Prospect']['fields']['nombre_c']['readonly_formula']='';

 ?>