<?php
 // created: 2019-12-26 22:25:25
$dictionary['Lead']['fields']['camara_c']['labelValue']='¿De qué Cámara Proviene?';
$dictionary['Lead']['fields']['camara_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['camara_c']['enforced']='';
$dictionary['Lead']['fields']['camara_c']['dependency']='equal($detalle_origen_c,"Afiliaciones")';

 ?>