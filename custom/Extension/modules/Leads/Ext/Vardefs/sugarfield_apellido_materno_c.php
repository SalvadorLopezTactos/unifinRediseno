<?php
 // created: 2020-01-02 00:03:41
$dictionary['Lead']['fields']['apellido_materno_c']['labelValue']='Apellido Materno';
$dictionary['Lead']['fields']['apellido_materno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['apellido_materno_c']['enforced']='';
$dictionary['Lead']['fields']['apellido_materno_c']['dependency']='or(
equal($regimen_fiscal_c,"Persona Fisica"),
equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial")
)';

 ?>