<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['idcliente_c']['labelValue'] = 'ID Cliente';
$dictionary['Account']['fields']['idcliente_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['idcliente_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['idcliente_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['idcliente_c']['enforced'] = '';
$dictionary['Account']['fields']['idcliente_c']['dependency'] = 'or(equal($tipo_registro_cuenta_c,"3"),equal($tipo_registro_cuenta_c,"5"),equal($tipo_registro_cuenta_c,"4"),equal($estatus_c,"Interesado"))';

