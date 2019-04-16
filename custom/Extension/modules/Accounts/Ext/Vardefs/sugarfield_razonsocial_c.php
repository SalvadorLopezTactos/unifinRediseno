<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['razonsocial_c']['labelValue'] = 'Razón Social';
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['razonsocial_c']['enforced'] = 'false';
$dictionary['Account']['fields']['razonsocial_c']['dependency'] = 'equal($tipodepersona_c,"Persona Moral")';

