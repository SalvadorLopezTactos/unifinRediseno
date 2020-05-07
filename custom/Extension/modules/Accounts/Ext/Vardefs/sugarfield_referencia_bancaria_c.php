<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['referencia_bancaria_c']['labelValue'] = 'Referencia Bancaria';
$dictionary['Account']['fields']['referencia_bancaria_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['referencia_bancaria_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['referencia_bancaria_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['referencia_bancaria_c']['enforced'] = '';
$dictionary['Account']['fields']['referencia_bancaria_c']['dependency'] = 'equal($tipo_registro_cuenta_c,"3")';

