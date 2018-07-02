<?php
 // created: 2017-12-26 14:30:41
$dictionary['User']['fields']['region_c']['duplicate_merge_dom_value']=0;
$dictionary['User']['fields']['region_c']['labelValue']='Región';
$dictionary['User']['fields']['region_c']['calculated']='true';
$dictionary['User']['fields']['region_c']['formula']='ifElse(
equal(getDropdownValue("tct_team_region_list",$equipo_c),""),
"",getDropdownValue("tct_team_region_list",$equipo_c)
)';
$dictionary['User']['fields']['region_c']['enforced']='true';
$dictionary['User']['fields']['region_c']['dependency']='';

 ?>