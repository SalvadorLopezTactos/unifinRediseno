<?php
 // created: 2021-09-23 10:06:28
$dictionary['Task']['fields']['fecha_calificacion_c']['duplicate_merge_dom_value']=0;
$dictionary['Task']['fields']['fecha_calificacion_c']['labelValue']='Fecha de calificación';
$dictionary['Task']['fields']['fecha_calificacion_c']['calculated']='1';
$dictionary['Task']['fields']['fecha_calificacion_c']['formula']='ifElse(equal($potencial_negocio_c,""),$fecha_vacia_c,ifElse(equal($fecha_vacia_c,""),now(),$fecha_vacia_c))';
$dictionary['Task']['fields']['fecha_calificacion_c']['enforced']='1';
$dictionary['Task']['fields']['fecha_calificacion_c']['dependency']='';

 ?>