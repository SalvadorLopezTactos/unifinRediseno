<?php
 // created: 2019-04-15 17:19:11
$dictionary['Lead']['fields']['apellidomaterno_c']['labelValue'] = 'Apellido Materno';
$dictionary['Lead']['fields']['apellidomaterno_c']['full_text_search']['enabled'] = true;
$dictionary['Lead']['fields']['apellidomaterno_c']['full_text_search']['searchable'] = true;
$dictionary['Lead']['fields']['apellidomaterno_c']['full_text_search']['boost'] = 1;
$dictionary['Lead']['fields']['apellidomaterno_c']['enforced'] = 'false';
$dictionary['Lead']['fields']['apellidomaterno_c']['dependency'] = 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))';

