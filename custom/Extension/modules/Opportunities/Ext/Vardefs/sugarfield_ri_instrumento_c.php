<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['ri_instrumento_c']['labelValue'] = 'Instrumento interés ordinario (Ratificación)';
$dictionary['Opportunity']['fields']['ri_instrumento_c']['dependency'] = 'and(equal($tipo_operacion_c,"2"),equal($ratificacion_incremento_c,"1"),equal($tipo_producto_c,"4"))';
$dictionary['Opportunity']['fields']['ri_instrumento_c']['visibility_grid'] = '';
$dictionary['Opportunity']['fields']['ri_instrumento_c']['full_text_search']['boost'] = 1;

