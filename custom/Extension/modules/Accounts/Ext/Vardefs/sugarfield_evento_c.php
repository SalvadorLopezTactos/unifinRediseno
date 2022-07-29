<?php
 // created: 2020-05-26 10:23:33
$dictionary['Account']['fields']['evento_c']['labelValue']='¿Qué Evento?';
$dictionary['Account']['fields']['evento_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Account']['fields']['evento_c']['enforced']='';
$dictionary['Account']['fields']['evento_c']['dependency']='equal($detalle_origen_c,"5")';

 ?>