<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['monto_ratificacion_increment_c']['labelValue'] = 'Monto Incremento/Ratificación';
$dictionary['Opportunity']['fields']['monto_ratificacion_increment_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['monto_ratificacion_increment_c']['dependency'] = 'and(equal($tipo_operacion_c,"2"),equal($ratificacion_incremento_c,"1"))';
$dictionary['Opportunity']['fields']['monto_ratificacion_increment_c']['related_fields'][0] = 'currency_id';
$dictionary['Opportunity']['fields']['monto_ratificacion_increment_c']['related_fields'][1] = 'base_rate';

