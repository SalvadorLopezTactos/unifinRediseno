<?php
 // created: 2021-04-20 18:31:07
$dictionary['User']['fields']['region_c']['duplicate_merge_dom_value']=0;
$dictionary['User']['fields']['region_c']['labelValue']='Región';
$dictionary['User']['fields']['region_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['User']['fields']['region_c']['calculated']='1';
$dictionary['User']['fields']['region_c']['formula']='ifElse(
equal(getDropdownValue("tct_team_region_list",$equipo_c),""),
"",getDropdownValue("tct_team_region_list",$equipo_c)
)';
$dictionary['User']['fields']['region_c']['enforced']='1';
$dictionary['User']['fields']['region_c']['dependency']='';

 ?>