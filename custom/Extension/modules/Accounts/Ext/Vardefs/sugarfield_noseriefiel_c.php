<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['noseriefiel_c']['labelValue'] = 'No Serie Fiel';
$dictionary['Account']['fields']['noseriefiel_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['noseriefiel_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['noseriefiel_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['noseriefiel_c']['enforced'] = 'false';
$dictionary['Account']['fields']['noseriefiel_c']['dependency'] = 'and(not(equal($tipodepersona_c,"Persona Moral")),equal($estatus_c,"Interesado"))';

