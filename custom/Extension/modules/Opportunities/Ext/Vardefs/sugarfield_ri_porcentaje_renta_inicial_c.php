<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['ri_porcentaje_renta_inicial_c']['labelValue'] = '% Renta Inicial Incremento/Ratificación';
$dictionary['Opportunity']['fields']['ri_porcentaje_renta_inicial_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ri_porcentaje_renta_inicial_c']['dependency'] = 'and(or(equal($tipo_producto_c,"1"),equal($tipo_producto_c,"3")),equal($ratificacion_incremento_c,"1"))';

