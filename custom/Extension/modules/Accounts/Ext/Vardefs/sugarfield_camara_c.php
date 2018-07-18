<?php
 // created: 2018-07-17 17:08:16
$dictionary['Account']['fields']['camara_c']['labelValue']='¿De qué Cámara Proviene?';
$dictionary['Account']['fields']['camara_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['camara_c']['enforced']='';
$dictionary['Account']['fields']['camara_c']['dependency']='equal($tct_detalle_origen_ddw_c,"Afiliaciones")';

 ?>