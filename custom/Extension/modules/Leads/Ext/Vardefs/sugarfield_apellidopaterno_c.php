<?php
 // created: 2018-12-05 18:17:34
$dictionary['Lead']['fields']['apellidopaterno_c']['labelValue'] = 'Apellido Paterno';
$dictionary['Lead']['fields']['apellidopaterno_c']['full_text_search']['enabled'] = true;
$dictionary['Lead']['fields']['apellidopaterno_c']['full_text_search']['searchable'] = true;
$dictionary['Lead']['fields']['apellidopaterno_c']['full_text_search']['boost'] = 1;
$dictionary['Lead']['fields']['apellidopaterno_c']['enforced'] = 'false';
$dictionary['Lead']['fields']['apellidopaterno_c']['dependency'] = 'or(equal($regimen_fiscal_c,"Persona Fisica"),equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial"))';

