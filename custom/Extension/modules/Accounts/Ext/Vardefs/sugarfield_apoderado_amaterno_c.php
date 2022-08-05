<?php
 // created: 2020-02-11 17:57:22
$dictionary['Account']['fields']['apoderado_amaterno_c']['labelValue']='Apellido materno (Apoderado legal)';
$dictionary['Account']['fields']['apoderado_amaterno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['apoderado_amaterno_c']['enforced']='';
$dictionary['Account']['fields']['apoderado_amaterno_c']['dependency']='equal($deudor_factor_c,"1")';

 ?>