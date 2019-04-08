<?php
 // created: 2019-04-08 16:21:37
$dictionary['User']['fields']['nombre_completo_c']['duplicate_merge_dom_value']=0;
$dictionary['User']['fields']['nombre_completo_c']['labelValue']='Nombre completo';
$dictionary['User']['fields']['nombre_completo_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['User']['fields']['nombre_completo_c']['calculated']='true';
$dictionary['User']['fields']['nombre_completo_c']['formula']='concat($first_name," ",$last_name)';
$dictionary['User']['fields']['nombre_completo_c']['enforced']='true';
$dictionary['User']['fields']['nombre_completo_c']['dependency']='';

 ?>