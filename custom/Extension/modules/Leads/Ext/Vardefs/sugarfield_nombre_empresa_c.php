<?php
 // created: 2021-04-20 17:30:29
$dictionary['Lead']['fields']['nombre_empresa_c']['labelValue']='Nombre Empresa';
$dictionary['Lead']['fields']['nombre_empresa_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['nombre_empresa_c']['enforced']='';
$dictionary['Lead']['fields']['nombre_empresa_c']['dependency']='equal($regimen_fiscal_c,"3")';

 ?>