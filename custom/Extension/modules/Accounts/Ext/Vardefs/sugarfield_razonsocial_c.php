<?php
 // created: 2018-08-08 12:57:37
$dictionary['Account']['fields']['razonsocial_c']['labelValue']='Razón Social';
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['razonsocial_c']['enforced']='false';
$dictionary['Account']['fields']['razonsocial_c']['dependency']='equal($tipodepersona_c,"Persona Moral")';

 ?>