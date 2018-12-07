<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['ri_cartera_descontar_c']['labelValue'] = 'Cartera a descontar (Ratificación)';
$dictionary['Opportunity']['fields']['ri_cartera_descontar_c']['full_text_search']['enabled'] = true;
$dictionary['Opportunity']['fields']['ri_cartera_descontar_c']['full_text_search']['searchable'] = true;
$dictionary['Opportunity']['fields']['ri_cartera_descontar_c']['full_text_search']['boost'] = 1;
$dictionary['Opportunity']['fields']['ri_cartera_descontar_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ri_cartera_descontar_c']['dependency'] = 'and(equal($tipo_operacion_c,"2"),equal($ratificacion_incremento_c,"1"),equal($tipo_producto_c,"4"))';

