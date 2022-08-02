<?php
 // created: 2021-07-20 13:13:40
$dictionary['S_seguros']['fields']['fin_vigencia_emitida_c']['labelValue']='Fecha de Fin de Vigencia de Póliza';
$dictionary['S_seguros']['fields']['fin_vigencia_emitida_c']['enforced']='false';
$dictionary['S_seguros']['fields']['fin_vigencia_emitida_c']['dependency']='and(equal($etapa,9),or(equal($subetapa_c,1),equal($subetapa_c,2)))';

 ?>