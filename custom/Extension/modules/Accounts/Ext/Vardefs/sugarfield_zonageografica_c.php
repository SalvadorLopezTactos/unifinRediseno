<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['zonageografica_c']['labelValue'] = 'Zona Geografica';
$dictionary['Account']['fields']['zonageografica_c']['dependency'] = 'or(not(equal($tipo_registro_c,"Prospecto")),equal($estatus_c,"Interesado"))';
$dictionary['Account']['fields']['zonageografica_c']['visibility_grid'] = '';
$dictionary['Account']['fields']['zonageografica_c']['full_text_search']['boost'] = 1;

