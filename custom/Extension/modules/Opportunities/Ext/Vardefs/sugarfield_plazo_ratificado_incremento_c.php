<?php
 // created: 2018-02-16 16:59:03
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['labelValue'] = 'Plazo para ratificación';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['dependency'] = 'equal($tipo_operacion_c,"2")';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['trigger'] = 'tipo_producto_c';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['values'][4][0] = '30';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['values'][4][1] = '60';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['values'][4][2] = '90';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['values'][4][3] = '120';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['values'][4][4] = '150';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['visibility_grid']['values'][4][5] = '180';
$dictionary['Opportunity']['fields']['plazo_ratificado_incremento_c']['full_text_search']['boost'] = 1;

