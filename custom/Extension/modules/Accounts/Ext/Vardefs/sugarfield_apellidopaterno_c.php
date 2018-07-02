<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['apellidopaterno_c']['labelValue'] = 'Apellido Paterno';
$dictionary['Account']['fields']['apellidopaterno_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['apellidopaterno_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['apellidopaterno_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['apellidopaterno_c']['enforced'] = 'false';
$dictionary['Account']['fields']['apellidopaterno_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

