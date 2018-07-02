<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['fechadenacimiento_c']['options'] = 'date_range_search_dom';
$dictionary['Account']['fields']['fechadenacimiento_c']['labelValue'] = 'Fecha de Nacimiento';
$dictionary['Account']['fields']['fechadenacimiento_c']['enforced'] = '';
$dictionary['Account']['fields']['fechadenacimiento_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';
$dictionary['Account']['fields']['fechadenacimiento_c']['enable_range_search'] = '1';
$dictionary['Account']['fields']['fechadenacimiento_c']['full_text_search']['boost'] = 1;

