<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['estadocivil_c']['labelValue'] = 'Estado Civil';
$dictionary['Account']['fields']['estadocivil_c']['dependency'] = 'and(not(equal($tipodepersona_c,"Persona Moral")),
or(equal($tipo_registro_c,"Cliente"),equal($tipo_registro_c,"Proveedor"),equal($tipo_registro_c,"Persona"),equal($estatus_c,"Interesado")))';
$dictionary['Account']['fields']['estadocivil_c']['visibility_grid'] = '';
$dictionary['Account']['fields']['estadocivil_c']['full_text_search']['boost'] = 1;

