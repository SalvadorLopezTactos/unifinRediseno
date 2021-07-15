<?php
 // created: 2021-07-08 22:09:27
$dictionary['S_seguros']['fields']['no_poliza_emitida_c']['labelValue']='Número de Póliza';
$dictionary['S_seguros']['fields']['no_poliza_emitida_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['no_poliza_emitida_c']['enforced']='';
$dictionary['S_seguros']['fields']['no_poliza_emitida_c']['dependency']='or(equal($subetapa_c,1),equal($subetapa_c,2))';

 ?>