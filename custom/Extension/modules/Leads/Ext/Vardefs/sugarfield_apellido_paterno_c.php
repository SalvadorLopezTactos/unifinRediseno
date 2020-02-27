<?php
 // created: 2020-02-13 22:45:25
$dictionary['Lead']['fields']['apellido_paterno_c']['labelValue']='Apellido Paterno';
$dictionary['Lead']['fields']['apellido_paterno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['apellido_paterno_c']['enforced']='';
$dictionary['Lead']['fields']['apellido_paterno_c']['dependency']='or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))';

 ?>