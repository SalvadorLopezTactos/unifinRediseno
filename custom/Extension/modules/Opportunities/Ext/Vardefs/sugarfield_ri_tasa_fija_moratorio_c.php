<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['ri_tasa_fija_moratorio_c']['labelValue'] = 'Tasa fija interés moratorio (Ratificación)';
$dictionary['Opportunity']['fields']['ri_tasa_fija_moratorio_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ri_tasa_fija_moratorio_c']['dependency'] = 'and(equal($tipo_operacion_c,"2"),equal($ratificacion_incremento_c,"1"),equal($tipo_producto_c,"4"),equal($ri_tipo_tasa_moratorio_c,"1"))';

