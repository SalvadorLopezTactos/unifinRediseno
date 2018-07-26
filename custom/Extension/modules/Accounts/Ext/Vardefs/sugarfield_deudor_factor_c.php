<?php
 // created: 2018-07-25 18:58:49
$dictionary['Account']['fields']['deudor_factor_c']['labelValue']='Deudor Factoraje';
$dictionary['Account']['fields']['deudor_factor_c']['enforced']='';
$dictionary['Account']['fields']['deudor_factor_c']['dependency']='not(
equal($tipo_registro_c,"Lead")
)';

 ?>