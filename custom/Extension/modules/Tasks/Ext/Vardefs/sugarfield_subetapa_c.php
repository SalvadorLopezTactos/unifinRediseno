<?php
 // created: 2021-09-23 13:02:29
$dictionary['Task']['fields']['subetapa_c']['duplicate_merge_dom_value']=0;
$dictionary['Task']['fields']['subetapa_c']['labelValue']='SubEtapa';
$dictionary['Task']['fields']['subetapa_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Task']['fields']['subetapa_c']['calculated']='true';
$dictionary['Task']['fields']['subetapa_c']['formula']='related($tasks_opportunities_1,"estatus_c")';
$dictionary['Task']['fields']['subetapa_c']['enforced']='true';
$dictionary['Task']['fields']['subetapa_c']['dependency']='';

 ?>