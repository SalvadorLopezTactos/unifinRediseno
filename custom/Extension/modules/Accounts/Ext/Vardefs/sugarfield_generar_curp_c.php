<?php
 // created: 2018-07-30 17:12:22
$dictionary['Account']['fields']['generar_curp_c']['labelValue']='Generar CURP';
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['generar_curp_c']['dependency']='not(equal($tipodepersona_c,"Persona Moral"))';

 ?>