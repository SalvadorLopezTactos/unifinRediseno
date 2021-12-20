<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['es_referenciador_c']['labelValue'] = 'Referenciador Autorizado';
$dictionary['Account']['fields']['es_referenciador_c']['enforced'] = '';
$dictionary['Account']['fields']['es_referenciador_c']['dependency'] = 'or(equal($tipo_registro_cuenta_c,"5"),equal($esproveedor_c,true))';

