<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['ifepasaporte_c']['labelValue'] = 'IFE/Pasaporte';
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['ifepasaporte_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['ifepasaporte_c']['enforced'] = '';
$dictionary['Account']['fields']['ifepasaporte_c']['dependency'] = 'and(not(equal($tipodepersona_c,"Persona Moral")),or(not(equal($tipo_registro_c,"Prospecto")),equal($estatus_c,"Interesado")))';

