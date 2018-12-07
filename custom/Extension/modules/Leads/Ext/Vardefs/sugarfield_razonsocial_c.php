<?php
 // created: 2018-12-05 18:17:34
$dictionary['Lead']['fields']['razonsocial_c']['labelValue'] = 'Razón Social';
$dictionary['Lead']['fields']['razonsocial_c']['full_text_search']['enabled'] = true;
$dictionary['Lead']['fields']['razonsocial_c']['full_text_search']['searchable'] = true;
$dictionary['Lead']['fields']['razonsocial_c']['full_text_search']['boost'] = 1;
$dictionary['Lead']['fields']['razonsocial_c']['enforced'] = 'false';
$dictionary['Lead']['fields']['razonsocial_c']['dependency'] = 'and(equal($regimen_fiscal_c,"Persona Moral"))';

