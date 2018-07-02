<?php
 // created: 2018-01-12 12:41:10
$dictionary['User']['fields']['tct_team_address_txf_c']['duplicate_merge_dom_value']=0;
$dictionary['User']['fields']['tct_team_address_txf_c']['labelValue']='Dirección';
$dictionary['User']['fields']['tct_team_address_txf_c']['calculated']='true';
$dictionary['User']['fields']['tct_team_address_txf_c']['formula']='ifElse(equal(getDropdownValue("tct_team_address_list",$equipo_c),""),getDropdownValue("tct_team_address_list","CASA"),getDropdownValue("tct_team_address_list",$equipo_c))';
$dictionary['User']['fields']['tct_team_address_txf_c']['enforced']='true';
$dictionary['User']['fields']['tct_team_address_txf_c']['dependency']='';

 ?>