<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['generar_curp_c']['labelValue'] = 'Generar CURP';
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['generar_curp_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['generar_curp_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

