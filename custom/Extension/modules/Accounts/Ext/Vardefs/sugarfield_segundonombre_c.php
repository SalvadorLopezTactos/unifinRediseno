<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['segundonombre_c']['labelValue'] = 'Segundo Nombre';
$dictionary['Account']['fields']['segundonombre_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['segundonombre_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['segundonombre_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['segundonombre_c']['enforced'] = 'false';
$dictionary['Account']['fields']['segundonombre_c']['dependency'] = 'not(equal($tipodepersona_c,"Persona Moral"))';

