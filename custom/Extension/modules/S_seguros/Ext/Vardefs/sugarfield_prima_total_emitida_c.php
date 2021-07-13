<?php
 // created: 2021-07-08 22:45:12
$dictionary['S_seguros']['fields']['prima_total_emitida_c']['labelValue']='Prima Total';
$dictionary['S_seguros']['fields']['prima_total_emitida_c']['enforced']='';
$dictionary['S_seguros']['fields']['prima_total_emitida_c']['dependency']='or(equal($subetapa_c,1),equal($subetapa_c,2))';
$dictionary['S_seguros']['fields']['prima_total_emitida_c']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);

 ?>