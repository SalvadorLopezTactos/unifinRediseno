<?php
 // created: 2018-08-27 09:11:59
$dictionary['User']['fields']['tct_team_address_txf_c']['duplicate_merge_dom_value']=0;
$dictionary['User']['fields']['tct_team_address_txf_c']['labelValue']='Dirección';
$dictionary['User']['fields']['tct_team_address_txf_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['User']['fields']['tct_team_address_txf_c']['calculated']='1';
$dictionary['User']['fields']['tct_team_address_txf_c']['formula']='ifElse(equal(getDropdownValue("tct_team_address_list",$equipo_c),""),getDropdownValue("tct_team_address_list","CASA"),getDropdownValue("tct_team_address_list",$equipo_c))';
$dictionary['User']['fields']['tct_team_address_txf_c']['enforced']='1';
$dictionary['User']['fields']['tct_team_address_txf_c']['dependency']='';

 ?>