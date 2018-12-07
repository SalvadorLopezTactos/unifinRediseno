<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['apellidomaterno_c']['labelValue'] = 'Apellido Materno';
$dictionary['Account']['fields']['apellidomaterno_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['apellidomaterno_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['apellidomaterno_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['apellidomaterno_c']['enforced'] = 'false';
$dictionary['Account']['fields']['apellidomaterno_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

