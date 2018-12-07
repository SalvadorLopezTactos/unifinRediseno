<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['curp_c']['labelValue'] = 'CURP';
$dictionary['Account']['fields']['curp_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['curp_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['curp_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['curp_c']['enforced'] = '';
$dictionary['Account']['fields']['curp_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

