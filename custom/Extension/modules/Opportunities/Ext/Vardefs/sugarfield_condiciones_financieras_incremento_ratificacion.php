<?php
 // created: 2018-02-16 16:59:03
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['audited'] = false;
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['massupdate'] = false;
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['duplicate_merge'] = 'enabled';
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['duplicate_merge_dom_value'] = '1';
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['merge_filter'] = 'disabled';
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['calculated'] = false;
$dictionary['Opportunity']['fields']['condiciones_financieras_incremento_ratificacion']['dependency'] = 'and(equal($ratificacion_incremento_c,1),equal($tipo_operacion_c,2),not(equal($tipo_producto_c,"4")))';

