<?php
 // created: 2019-04-02 13:22:16
$dictionary['User']['fields']['iniciales_c']['duplicate_merge_dom_value']=0;
$dictionary['User']['fields']['iniciales_c']['labelValue']='Iniciales';
$dictionary['User']['fields']['iniciales_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['User']['fields']['iniciales_c']['calculated']='true';
$dictionary['User']['fields']['iniciales_c']['formula']='iniciales(concat($first_name," ",$last_name))';
$dictionary['User']['fields']['iniciales_c']['enforced']='true';
$dictionary['User']['fields']['iniciales_c']['dependency']='';

 ?>