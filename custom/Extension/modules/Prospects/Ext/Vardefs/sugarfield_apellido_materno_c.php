<?php
 // created: 2022-04-25 17:14:01
$dictionary['Prospect']['fields']['apellido_materno_c']['labelValue']='Apellido Materno';
$dictionary['Prospect']['fields']['apellido_materno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['apellido_materno_c']['enforced']='';
$dictionary['Prospect']['fields']['apellido_materno_c']['dependency']='or(equal($regimen_fiscal_c,"1"),equal($regimen_fiscal_c,"2"))';
$dictionary['Prospect']['fields']['apellido_materno_c']['required_formula']='';
$dictionary['Prospect']['fields']['apellido_materno_c']['readonly_formula']='';

 ?>