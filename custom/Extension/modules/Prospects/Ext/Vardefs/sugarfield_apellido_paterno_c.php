<?php
 // created: 2022-04-29 17:25:25
$dictionary['Prospect']['fields']['apellido_paterno_c']['labelValue']='Apellido Paterno';
$dictionary['Prospect']['fields']['apellido_paterno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['apellido_paterno_c']['enforced']='';
$dictionary['Prospect']['fields']['apellido_paterno_c']['dependency']='not(equal($regimen_fiscal_c,"3"))';
$dictionary['Prospect']['fields']['apellido_paterno_c']['required_formula']='not(equal($regimen_fiscal_c,"3"))';
$dictionary['Prospect']['fields']['apellido_paterno_c']['readonly_formula']='';

 ?>