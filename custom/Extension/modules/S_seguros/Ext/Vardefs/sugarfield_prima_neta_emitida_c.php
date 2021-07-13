<?php
 // created: 2021-07-08 22:38:49
$dictionary['S_seguros']['fields']['prima_neta_emitida_c']['labelValue']='Prima Neta';
$dictionary['S_seguros']['fields']['prima_neta_emitida_c']['enforced']='';
$dictionary['S_seguros']['fields']['prima_neta_emitida_c']['dependency']='or(equal($subetapa_c,1),equal($subetapa_c,2))';
$dictionary['S_seguros']['fields']['prima_neta_emitida_c']['related_fields']=array (
  0 => 'currency_id',
  1 => 'base_rate',
);

 ?>