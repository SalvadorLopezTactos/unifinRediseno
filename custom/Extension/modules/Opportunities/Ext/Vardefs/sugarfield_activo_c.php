<?php
 // created: 2018-02-16 16:59:03
$dictionary['Opportunity']['fields']['activo_c']['labelValue'] = 'Activo';
$dictionary['Opportunity']['fields']['activo_c']['full_text_search']['enabled'] = true;
$dictionary['Opportunity']['fields']['activo_c']['full_text_search']['searchable'] = false;
$dictionary['Opportunity']['fields']['activo_c']['full_text_search']['boost'] = 1;
$dictionary['Opportunity']['fields']['activo_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['activo_c']['dependency'] = 'not(equal($tipo_producto_c,"4"))';
$dictionary['Opportunity']['fields']['activo_c']['type'] = 'activo_enum';
$dictionary['Opportunity']['fields']['sub_activo_c']['type'] = 'subactivo_enum';

