<?php
 // created: 2018-02-16 16:59:03
$dictionary['Opportunity']['fields']['porciento_ri_c']['labelValue'] = '% Renta Inicial';
$dictionary['Opportunity']['fields']['porciento_ri_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['porciento_ri_c']['dependency'] = 'and(not(equal($tipo_producto_c,"4")),equal($tipo_operacion_c,"1"))';

