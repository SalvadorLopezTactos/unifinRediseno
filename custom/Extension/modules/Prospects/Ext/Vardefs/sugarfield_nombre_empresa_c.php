<?php
 // created: 2022-05-04 20:30:44
$dictionary['Prospect']['fields']['nombre_empresa_c']['labelValue']='Nombre Empresa';
$dictionary['Prospect']['fields']['nombre_empresa_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['nombre_empresa_c']['enforced']='false';
$dictionary['Prospect']['fields']['nombre_empresa_c']['dependency']='equal($regimen_fiscal_c,"3")';
$dictionary['Prospect']['fields']['nombre_empresa_c']['required_formula']='equal($regimen_fiscal_c,"3")';
$dictionary['Prospect']['fields']['nombre_empresa_c']['readonly_formula']='';

 ?>