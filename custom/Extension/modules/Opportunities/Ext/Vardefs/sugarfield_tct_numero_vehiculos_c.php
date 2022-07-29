<?php
 // created: 2021-05-07 01:56:07
$dictionary['Opportunity']['fields']['tct_numero_vehiculos_c']['labelValue']='Número de vehículos';
$dictionary['Opportunity']['fields']['tct_numero_vehiculos_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Opportunity']['fields']['tct_numero_vehiculos_c']['enforced']='';
$dictionary['Opportunity']['fields']['tct_numero_vehiculos_c']['dependency']='or(equal($tipo_producto_c,6),equal($tipo_producto_c,13))';

 ?>