<?php
 // created: 2018-08-29 17:42:11
$dictionary['Account']['fields']['nombre_comercial_c']['labelValue']='Nombre Comercial';
$dictionary['Account']['fields']['nombre_comercial_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['nombre_comercial_c']['calculated']='1';
$dictionary['Account']['fields']['nombre_comercial_c']['formula']='ifElse(
equal($nombre_comercial_c,""),
$name,
$nombre_comercial_c
)';
$dictionary['Account']['fields']['nombre_comercial_c']['enforced']='';
$dictionary['Account']['fields']['nombre_comercial_c']['dependency']='equal($tipodepersona_c,"Persona Moral")';

 ?>