<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['ifepasaporte_c']['labelValue'] = 'IFE/Pasaporte';
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['ifepasaporte_c']['enforced'] = '';
$dictionary['Account']['fields']['ifepasaporte_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

