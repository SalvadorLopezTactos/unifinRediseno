<?php
 // created: 2020-05-08 15:10:45
$dictionary['Lead']['fields']['evento_c']['labelValue']='¿Qué Evento?';
$dictionary['Lead']['fields']['evento_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Lead']['fields']['evento_c']['enforced']='';
$dictionary['Lead']['fields']['evento_c']['dependency']='equal($detalle_origen_c,"5")';

 ?>