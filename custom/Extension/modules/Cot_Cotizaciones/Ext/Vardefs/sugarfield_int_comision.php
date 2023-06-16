<?php
 // created: 2023-06-16 14:56:52
$dictionary['Cot_Cotizaciones']['fields']['int_comision']['dependency']='equal(related($cot_cotizaciones_s_seguros,"creditaria_c"),"Seguros")';
$dictionary['Cot_Cotizaciones']['fields']['int_comision']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);

 ?>