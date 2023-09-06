<?php
 // created: 2023-09-05 23:00:48
$dictionary['S_seguros']['fields']['id_poliza_c']['labelValue']='Id de Póliza Interprotección';
$dictionary['S_seguros']['fields']['id_poliza_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['id_poliza_c']['enforced']='';
$dictionary['S_seguros']['fields']['id_poliza_c']['dependency']='and(equal($etapa,9),or(equal($subetapa_c,1),equal($subetapa_c,2)))';
$dictionary['S_seguros']['fields']['id_poliza_c']['required_formula']='';
$dictionary['S_seguros']['fields']['id_poliza_c']['readonly_formula']='';

 ?>