<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['lista_negra_c']['labelValue'] = 'Lista Negra';
$dictionary['Account']['fields']['lista_negra_c']['dependency'] = 'and(not(equal($idcliente_c,"")),not(equal($idprospecto_c,"")))';
$dictionary['Account']['fields']['lista_negra_c']['visibility_grid'] = '';
$dictionary['Account']['fields']['lista_negra_c']['full_text_search']['boost'] = 1;

