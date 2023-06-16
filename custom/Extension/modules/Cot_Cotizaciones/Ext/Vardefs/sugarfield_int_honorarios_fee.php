<?php
 // created: 2023-06-16 15:01:25
$dictionary['Cot_Cotizaciones']['fields']['int_honorarios_fee']['dependency']='equal(related($cot_cotizaciones_s_seguros,"creditaria_c"),"Seguros")';
$dictionary['Cot_Cotizaciones']['fields']['int_honorarios_fee']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);

 ?>