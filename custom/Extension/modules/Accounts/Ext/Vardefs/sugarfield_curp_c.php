<?php
 // created: 2018-07-16 11:38:47
$dictionary['Account']['fields']['curp_c']['labelValue']='CURP';
$dictionary['Account']['fields']['curp_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['curp_c']['enforced']='';
$dictionary['Account']['fields']['curp_c']['dependency']='not(equal($tipodepersona_c,"Persona Moral"))';

 ?>