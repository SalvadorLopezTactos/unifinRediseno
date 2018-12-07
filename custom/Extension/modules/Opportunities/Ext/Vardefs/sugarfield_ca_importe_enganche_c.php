<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['labelValue'] = 'Enganche';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['dependency'] = 'and(equal($tipo_operacion_c,"1"),or(equal($tipo_producto_c,"1"),equal($tipo_producto_c,"3")))';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['related_fields'][0] = 'currency_id';
$dictionary['Opportunity']['fields']['ca_importe_enganche_c']['related_fields'][1] = 'base_rate';

