<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['ri_porcentaje_ca_c']['labelValue'] = 'Comisión por apertura Incremento/Ratificación';
$dictionary['Opportunity']['fields']['ri_porcentaje_ca_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ri_porcentaje_ca_c']['dependency'] = 'and(equal($ratificacion_incremento_c,1),equal($tipo_operacion_c,2),equal($tipo_producto_c,"4"))';

