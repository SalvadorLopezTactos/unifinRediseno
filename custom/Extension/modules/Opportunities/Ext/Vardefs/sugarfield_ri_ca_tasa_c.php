<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['ri_ca_tasa_c']['labelValue'] = 'Tasa Incremento/Ratificación';
$dictionary['Opportunity']['fields']['ri_ca_tasa_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ri_ca_tasa_c']['dependency'] = 'and(or(equal($tipo_producto_c,"1"),equal($tipo_producto_c,"4"),equal($tipo_producto_c,"3")),equal($ratificacion_incremento_c,"1"))';

