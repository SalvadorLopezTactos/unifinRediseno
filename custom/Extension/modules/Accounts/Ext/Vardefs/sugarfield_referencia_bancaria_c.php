<?php
 // created: 2018-07-10 12:45:44
$dictionary['Account']['fields']['referencia_bancaria_c']['labelValue']='Referencia Bancaria';
$dictionary['Account']['fields']['referencia_bancaria_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['referencia_bancaria_c']['enforced']='';
$dictionary['Account']['fields']['referencia_bancaria_c']['dependency']='equal($tipo_registro_c,"Cliente")';

 ?>