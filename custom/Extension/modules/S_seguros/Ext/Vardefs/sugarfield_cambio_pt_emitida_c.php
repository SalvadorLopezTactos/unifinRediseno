<?php
 // created: 2021-07-08 22:46:30
$dictionary['S_seguros']['fields']['cambio_pt_emitida_c']['labelValue']='Tipo de Cambio PT';
$dictionary['S_seguros']['fields']['cambio_pt_emitida_c']['enforced']='';
$dictionary['S_seguros']['fields']['cambio_pt_emitida_c']['dependency']='and(or(equal($subetapa_c,1),equal($subetapa_c,2)),not(equal($monedas_c,1)))';

 ?>