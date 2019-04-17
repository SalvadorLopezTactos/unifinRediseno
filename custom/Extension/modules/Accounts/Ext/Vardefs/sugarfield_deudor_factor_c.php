<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['deudor_factor_c']['labelValue'] = 'Deudor Factoraje';
$dictionary['Account']['fields']['deudor_factor_c']['enforced'] = '';
$dictionary['Account']['fields']['deudor_factor_c']['dependency'] = 'not(
equal($tipo_registro_c,"Lead")
)';

