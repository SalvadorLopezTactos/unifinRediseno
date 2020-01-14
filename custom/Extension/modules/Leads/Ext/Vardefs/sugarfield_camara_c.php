<?php
 // created: 2020-01-13 21:30:17
$dictionary['Lead']['fields']['camara_c']['labelValue']='¿De qué Cámara Proviene?';
$dictionary['Lead']['fields']['camara_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['camara_c']['enforced']='';
$dictionary['Lead']['fields']['camara_c']['dependency']='equal($detalle_origen_c,"Afiliaciones")';

 ?>