<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['razonsocial_c']['labelValue'] = 'Razon Social';
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['razonsocial_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['razonsocial_c']['enforced'] = 'false';
$dictionary['Account']['fields']['razonsocial_c']['dependency'] = 'equal($tipodepersona_c,"Persona Moral")';

