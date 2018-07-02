<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['generar_curp_c']['labelValue'] = 'Generar CURP';
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['generar_curp_c']['dependency'] = 'and(not(equal($tipodepersona_c,"Persona Moral")),or(not(equal($tipo_registro_c,"Prospecto")),equal($estatus_c,"Interesado")))';

