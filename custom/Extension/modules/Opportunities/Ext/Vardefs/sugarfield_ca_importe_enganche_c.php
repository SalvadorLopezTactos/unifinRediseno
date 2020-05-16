<?php
 // created: 2020-05-16 02:25:42
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['labelValue']='Renta inicial';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['enforced']='';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['dependency']='and(equal($tipo_operacion_c,"1"),or(equal($tipo_producto_c,"1"),equal($tipo_producto_c,"9"),equal($tipo_producto_c,"3")))';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);

 ?>