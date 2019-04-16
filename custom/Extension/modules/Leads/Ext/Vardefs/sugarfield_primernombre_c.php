<?php
 // created: 2019-04-15 17:19:11
$dictionary['Lead']['fields']['primernombre_c']['labelValue'] = 'Primer Nombre';
$dictionary['Lead']['fields']['primernombre_c']['full_text_search']['enabled'] = true;
$dictionary['Lead']['fields']['primernombre_c']['full_text_search']['searchable'] = true;
$dictionary['Lead']['fields']['primernombre_c']['full_text_search']['boost'] = 1;
$dictionary['Lead']['fields']['primernombre_c']['enforced'] = 'false';
$dictionary['Lead']['fields']['primernombre_c']['dependency'] = 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))';

