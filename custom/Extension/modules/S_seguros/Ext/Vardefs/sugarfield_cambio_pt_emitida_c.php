<?php
 // created: 2021-07-20 13:15:38
$dictionary['S_seguros']['fields']['cambio_pt_emitida_c']['labelValue']='Tipo de Cambio';
$dictionary['S_seguros']['fields']['cambio_pt_emitida_c']['enforced']='';
$dictionary['S_seguros']['fields']['cambio_pt_emitida_c']['dependency']='and(equal($etapa,9),or(equal($subetapa_c,1),equal($subetapa_c,2)),not(equal($monedas_c,1)))';

 ?>