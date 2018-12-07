<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['activo_c']['labelValue'] = 'Activo';
$dictionary['Opportunity']['fields']['activo_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['activo_c']['dependency'] = 'not(equal($tipo_producto_c,"4"))';
$dictionary['Opportunity']['fields']['activo_c']['type'] = 'activo_enum';
$dictionary['Opportunity']['fields']['sub_activo_c']['type'] = 'subactivo_enum';

