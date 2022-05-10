<?php
 // created: 2020-02-11 17:46:28
$dictionary['Account']['fields']['apoderado_nombre_c']['labelValue']='Nombre (Apoderado legal)';
$dictionary['Account']['fields']['apoderado_nombre_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['apoderado_nombre_c']['enforced']='';
$dictionary['Account']['fields']['apoderado_nombre_c']['dependency']='equal($deudor_factor_c,"1")';

 ?>