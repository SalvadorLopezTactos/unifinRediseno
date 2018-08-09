<?php
 // created: 2018-08-01 17:44:14
$dictionary['Account']['fields']['razonsocial_c']['labelValue']='Razon Social';
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['razonsocial_c']['enforced']='false';
$dictionary['Account']['fields']['razonsocial_c']['dependency']='equal($tipodepersona_c,"Persona Moral")';

 ?>