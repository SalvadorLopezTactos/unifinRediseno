<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['curp_c']['labelValue'] = 'CURP';
$dictionary['Account']['fields']['curp_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['curp_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['curp_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['curp_c']['enforced'] = '';
$dictionary['Account']['fields']['curp_c']['dependency'] = 'and(not(equal($tipodepersona_c,"Persona Moral")),or(not(equal($tipo_registro_c,"Prospecto")),equal($estatus_c,"Interesado")))';

