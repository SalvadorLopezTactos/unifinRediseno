<?php
 // created: 2018-07-25 17:37:33
$dictionary['Account']['fields']['razonsocial_c']['labelValue']='Razon Social';
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['razonsocial_c']['enforced']='false';
$dictionary['Account']['fields']['razonsocial_c']['dependency']='not(equal($tipodepersona_c,"Persona Fisica"))';

 ?>