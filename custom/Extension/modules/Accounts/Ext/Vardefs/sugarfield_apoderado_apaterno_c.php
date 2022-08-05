<?php
 // created: 2020-02-11 17:50:20
$dictionary['Account']['fields']['apoderado_apaterno_c']['labelValue']='Apellido paterno (Apoderado legal)';
$dictionary['Account']['fields']['apoderado_apaterno_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['apoderado_apaterno_c']['enforced']='';
$dictionary['Account']['fields']['apoderado_apaterno_c']['dependency']='equal($deudor_factor_c,"1")';

 ?>