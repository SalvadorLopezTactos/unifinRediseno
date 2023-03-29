<?php
 // created: 2023-03-06 14:26:58
$dictionary['Account']['fields']['razonsocial_c']['labelValue']='Razón Social';
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['razonsocial_c']['enforced']='false';
$dictionary['Account']['fields']['razonsocial_c']['dependency']='equal($tipodepersona_c,"Persona Moral")';
$dictionary['Account']['fields']['razonsocial_c']['required_formula']='equal($tipodepersona_c,"Persona Moral")';
$dictionary['Account']['fields']['razonsocial_c']['readonly_formula']='';

 ?>