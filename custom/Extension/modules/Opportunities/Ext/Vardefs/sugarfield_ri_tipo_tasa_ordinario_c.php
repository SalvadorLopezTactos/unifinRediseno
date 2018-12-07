<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['ri_tipo_tasa_ordinario_c']['labelValue'] = 'Tipo tasa interés ordinario (Ratificación)';
$dictionary['Opportunity']['fields']['ri_tipo_tasa_ordinario_c']['dependency'] = 'and(equal($tipo_operacion_c,"2"),equal($ratificacion_incremento_c,"1"),equal($tipo_producto_c,"4"))';
$dictionary['Opportunity']['fields']['ri_tipo_tasa_ordinario_c']['visibility_grid'] = '';
$dictionary['Opportunity']['fields']['ri_tipo_tasa_ordinario_c']['full_text_search']['boost'] = 1;

