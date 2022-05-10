<?php
 // created: 2019-04-15 17:19:11
$dictionary['minut_Minutas']['fields']['fecha_y_hora_c']['dependency'] = 'or(equal($tct_programa_nueva_reunion_chk,1),
and(equal($tct_motivo_c,"10"),equal($tct_cliente_no_interesado_chk,true)))';
$dictionary['minut_Minutas']['fields']['fecha_y_hora_c']['required'] = true;
$dictionary['minut_Minutas']['fields']['fecha_y_hora_c']['full_text_search']['boost'] = 1;

