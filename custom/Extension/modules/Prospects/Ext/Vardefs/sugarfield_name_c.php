<?php
 // created: 2022-05-03 00:53:04
$dictionary['Prospect']['fields']['name_c']['duplicate_merge_dom_value']=0;
$dictionary['Prospect']['fields']['name_c']['labelValue']='Nombre PO';
$dictionary['Prospect']['fields']['name_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Prospect']['fields']['name_c']['calculated']='true';
$dictionary['Prospect']['fields']['name_c']['formula']='ifElse(equal($regimen_fiscal_c,"3"),$nombre_empresa_c,concat($nombre_c," ",$apellido_paterno_c," ",$apellido_materno_c))';
$dictionary['Prospect']['fields']['name_c']['enforced']='true';
$dictionary['Prospect']['fields']['name_c']['dependency']='';
$dictionary['Prospect']['fields']['name_c']['required_formula']='';
$dictionary['Prospect']['fields']['name_c']['readonly_formula']='';

 ?>