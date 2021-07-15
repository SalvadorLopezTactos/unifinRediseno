<?php
 // created: 2021-07-08 22:43:47
$dictionary['S_seguros']['fields']['cambio_pn_emitida_c']['labelValue']='Tipo de Cambio';
$dictionary['S_seguros']['fields']['cambio_pn_emitida_c']['enforced']='';
$dictionary['S_seguros']['fields']['cambio_pn_emitida_c']['dependency']='and(or(equal($subetapa_c,1),equal($subetapa_c,2)),not(equal($monedas_c,1)))';

 ?>