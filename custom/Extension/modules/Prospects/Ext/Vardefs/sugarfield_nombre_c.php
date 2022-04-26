<?php
 // created: 2022-04-25 17:08:13
$dictionary['Prospect']['fields']['nombre_c']['labelValue']='Nombre';
$dictionary['Prospect']['fields']['nombre_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['nombre_c']['enforced']='';
$dictionary['Prospect']['fields']['nombre_c']['dependency']='not(equal($regimen_fiscal_c,"Persona Moral"))';
$dictionary['Prospect']['fields']['nombre_c']['required_formula']='';
$dictionary['Prospect']['fields']['nombre_c']['readonly_formula']='';

 ?>