<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['nombre_comercial_c']['labelValue'] = 'Nombre Comercial';
$dictionary['Account']['fields']['nombre_comercial_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['nombre_comercial_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['nombre_comercial_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['nombre_comercial_c']['calculated'] = '1';
$dictionary['Account']['fields']['nombre_comercial_c']['formula'] = 'ifElse(
equal($nombre_comercial_c,""),
$name,
$nombre_comercial_c
)';
$dictionary['Account']['fields']['nombre_comercial_c']['enforced'] = '';
$dictionary['Account']['fields']['nombre_comercial_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Fisica"))';

