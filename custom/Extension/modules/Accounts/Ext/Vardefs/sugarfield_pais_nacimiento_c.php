<?php
 // created: 2018-07-11 13:38:13
$dictionary['Account']['fields']['pais_nacimiento_c']['labelValue']='Pais de nacimiento';
$dictionary['Account']['fields']['pais_nacimiento_c']['dependency']='and(or(not(equal($tipo_registro_c,"Prospecto")),equal($estatus_c,"Interesado")),not(equal($tipodepersona_c,"Persona Moral")))';
$dictionary['Account']['fields']['pais_nacimiento_c']['visibility_grid']='';
$dictionary['Account']['fields']['pais_nacimiento_c']['full_text_search']['boost'] = 1;

 ?>
