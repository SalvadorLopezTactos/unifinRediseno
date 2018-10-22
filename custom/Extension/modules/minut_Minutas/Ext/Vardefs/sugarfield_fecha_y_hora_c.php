<?php
 // created: 2018-10-22 13:40:31
$dictionary['minut_Minutas']['fields']['fecha_y_hora_c']['dependency']='or(equal($tct_programa_nueva_reunion_chk,1),
and(equal($tct_motivo_c,"10"),equal($tct_cliente_no_interesado_chk,true)))';

 ?>