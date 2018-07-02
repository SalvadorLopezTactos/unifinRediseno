<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['deudor_factor_c']['labelValue'] = 'Deudor Factoraje';
$dictionary['Account']['fields']['deudor_factor_c']['enforced'] = '';
$dictionary['Account']['fields']['deudor_factor_c']['dependency'] = 'or(equal($tipo_registro_c,"Cliente"),equal($tipo_registro_c,"Persona"),equal($tipo_registro_c,"Proveedor"))';

