<?php
 // created: 2022-03-14 00:31:33
$dictionary['Opportunity']['fields']['evento_c']['labelValue']='¿Qué Evento?';
$dictionary['Opportunity']['fields']['evento_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Opportunity']['fields']['evento_c']['formula']='equal($detalle_origen_c,"5")';
$dictionary['Opportunity']['fields']['evento_c']['enforced']='false';
$dictionary['Opportunity']['fields']['evento_c']['dependency']='equal($detalle_origen_c,"5")';
$dictionary['Opportunity']['fields']['evento_c']['required_formula']='';
$dictionary['Opportunity']['fields']['evento_c']['readonly_formula']='';

 ?>