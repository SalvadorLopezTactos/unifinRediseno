<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['referenciado_agencia_c']['labelValue'] = 'Referenciado por';
$dictionary['Account']['fields']['referenciado_agencia_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['referenciado_agencia_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['referenciado_agencia_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['referenciado_agencia_c']['enforced'] = '';
$dictionary['Account']['fields']['referenciado_agencia_c']['dependency'] = 'equal($origendelprospecto_c,"Agencia Distribuidor")';

