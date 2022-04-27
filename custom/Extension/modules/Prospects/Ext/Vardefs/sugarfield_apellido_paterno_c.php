<?php
 // created: 2022-04-25 17:15:12
$dictionary['Prospect']['fields']['apellido_paterno_c']['labelValue']='Apellido Paterno';
$dictionary['Prospect']['fields']['apellido_paterno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['apellido_paterno_c']['enforced']='';
$dictionary['Prospect']['fields']['apellido_paterno_c']['dependency']='or(equal($regimen_fiscal_c,"1"),equal($regimen_fiscal_c,"2"))';
$dictionary['Prospect']['fields']['apellido_paterno_c']['required_formula']='';
$dictionary['Prospect']['fields']['apellido_paterno_c']['readonly_formula']='';

 ?>