<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['deudor_factor_c']['labelValue'] = 'Deudor Factoraje';
$dictionary['Account']['fields']['deudor_factor_c']['enforced'] = '';
$dictionary['Account']['fields']['deudor_factor_c']['dependency'] = 'not(
equal($tipo_registro_c,"Lead")
)';

