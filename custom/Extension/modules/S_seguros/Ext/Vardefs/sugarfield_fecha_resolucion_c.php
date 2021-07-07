<?php
 // created: 2021-07-07 14:38:53
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['labelValue']='Fecha de Resolución';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['formula']='ifElse(
and(
equal($fecha_resolucion_c,""),
or(equal($etapa,"9"),equal($etapa,"10"))
),
today(),
$fecha_resolucion_c
)';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['enforced']='false';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['dependency']='';

 ?>