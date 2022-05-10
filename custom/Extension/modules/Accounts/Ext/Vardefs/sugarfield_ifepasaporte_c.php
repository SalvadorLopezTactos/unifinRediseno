<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['ifepasaporte_c']['labelValue'] = 'IFE/Pasaporte';
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['ifepasaporte_c']['enforced'] = '';
$dictionary['Account']['fields']['ifepasaporte_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

