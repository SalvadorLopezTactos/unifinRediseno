<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['es_referenciador_c']['labelValue'] = 'Referenciador Autorizado';
$dictionary['Account']['fields']['es_referenciador_c']['enforced'] = '';
$dictionary['Account']['fields']['es_referenciador_c']['dependency'] = 'or(equal($tipo_registro_c,"Proveedor"),equal($esproveedor_c,true))';

