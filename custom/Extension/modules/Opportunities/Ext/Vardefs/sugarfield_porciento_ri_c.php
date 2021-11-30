<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['porciento_ri_c']['labelValue'] = '% Renta Inicial';
$dictionary['Opportunity']['fields']['porciento_ri_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['porciento_ri_c']['dependency'] = 'and(not(equal($tipo_producto_c,"4")),equal($tipo_operacion_c,"1"))';

