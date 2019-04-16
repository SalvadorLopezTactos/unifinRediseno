<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['puesto_c']['labelValue'] = 'Puesto';
$dictionary['Account']['fields']['puesto_c']['dependency'] = 'or(
equal($tipodepersona_c,"Persona Fisica"),
equal($tipodepersona_c,"Persona Fisica con Actividad Empresarial")
)';
$dictionary['Account']['fields']['puesto_c']['visibility_grid'] = '';
$dictionary['Account']['fields']['puesto_c']['full_text_search']['boost'] = 1;

