<?php
 // created: 2018-08-08 13:56:35
$dictionary['Account']['fields']['ifepasaporte_c']['labelValue']='IFE/Pasaporte';
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['ifepasaporte_c']['enforced']='';
$dictionary['Account']['fields']['ifepasaporte_c']['dependency']='not(equal($tipodepersona_c,"Persona Moral"))';

 ?>