<?php
 // created: 2021-07-20 13:18:35
$dictionary['S_seguros']['fields']['comentarios_ganada_c']['labelValue']='Comentarios';
$dictionary['S_seguros']['fields']['comentarios_ganada_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['comentarios_ganada_c']['enforced']='';
$dictionary['S_seguros']['fields']['comentarios_ganada_c']['dependency']='and(equal($etapa,9),equal($subetapa_c,3))';

 ?>