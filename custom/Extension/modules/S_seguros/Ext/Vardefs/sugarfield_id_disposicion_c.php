<?php
 // created: 2020-11-10 12:34:13
$dictionary['S_seguros']['fields']['id_disposicion_c']['labelValue']='Id Disposición';
$dictionary['S_seguros']['fields']['id_disposicion_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['id_disposicion_c']['enforced']='';
$dictionary['S_seguros']['fields']['id_disposicion_c']['dependency']='ifElse(equal($producto_c,""),false,true)';

 ?>