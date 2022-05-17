<?php
 // created: 2021-07-07 18:19:12
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['duplicate_merge_dom_value']=0;
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['labelValue']='Fecha de Resolución';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['calculated']='true';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['formula']='ifElse(
and(
equal($fecha_resolucion_c,""),
or(equal($etapa,"9"),equal($etapa,"10"))
),
today(),
$fecha_resolucion_c
)';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['enforced']='true';
$dictionary['S_seguros']['fields']['fecha_resolucion_c']['dependency']='';

 ?>