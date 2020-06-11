<?php
 // created: 2020-05-26 10:38:31
$dictionary['Account']['fields']['camara_c']['labelValue']='¿De qué Cámara Proviene?';
$dictionary['Account']['fields']['camara_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Account']['fields']['camara_c']['enforced']='';
$dictionary['Account']['fields']['camara_c']['dependency']='equal($detalle_origen_c,"6")';

 ?>