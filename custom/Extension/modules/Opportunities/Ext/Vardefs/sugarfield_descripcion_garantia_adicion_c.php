<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['descripcion_garantia_adicion_c']['labelValue'] = 'Descripción Garantías Adicionales';
$dictionary['Opportunity']['fields']['descripcion_garantia_adicion_c']['full_text_search']['enabled'] = true;
$dictionary['Opportunity']['fields']['descripcion_garantia_adicion_c']['full_text_search']['searchable'] = true;
$dictionary['Opportunity']['fields']['descripcion_garantia_adicion_c']['full_text_search']['boost'] = 1;
$dictionary['Opportunity']['fields']['descripcion_garantia_adicion_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['descripcion_garantia_adicion_c']['dependency'] = 'and(equal($tipo_producto_c,"1"),equal($garantia_adicional_c,"1"),equal($tipo_operacion_c,"1"))';

