<?php
 // created: 2020-02-13 23:25:25
$dictionary['Lead']['fields']['name_c']['duplicate_merge_dom_value']=0;
$dictionary['Lead']['fields']['name_c']['labelValue']='Nombre';
$dictionary['Lead']['fields']['name_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Lead']['fields']['name_c']['calculated']='1';
$dictionary['Lead']['fields']['name_c']['formula']='ifElse(equal($regimen_fiscal_c,"Persona Moral"),$nombre_empresa_c,concat($nombre_c," ",$apellido_paterno_c," ",$apellido_materno_c))';
$dictionary['Lead']['fields']['name_c']['enforced']='1';
$dictionary['Lead']['fields']['name_c']['dependency']='';

 ?>