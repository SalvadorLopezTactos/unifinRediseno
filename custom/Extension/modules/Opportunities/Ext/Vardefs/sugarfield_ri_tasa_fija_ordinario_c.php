<?php
 // created: 2018-02-16 16:59:03
$dictionary['Opportunity']['fields']['ri_tasa_fija_ordinario_c']['labelValue'] = 'Tasa fija interés ordinario (Ratificación)';
$dictionary['Opportunity']['fields']['ri_tasa_fija_ordinario_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['ri_tasa_fija_ordinario_c']['dependency'] = 'and(equal($tipo_operacion_c,"2"),equal($ratificacion_incremento_c,"1"),equal($tipo_producto_c,"4"),equal($ri_tipo_tasa_ordinario_c,"1"))';

