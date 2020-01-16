<?php
 // created: 2020-01-14 17:23:26
$dictionary['Task']['fields']['name']['len']='200';
$dictionary['Task']['fields']['name']['audited']=false;
$dictionary['Task']['fields']['name']['massupdate']=false;
$dictionary['Task']['fields']['name']['duplicate_merge']='disabled';
$dictionary['Task']['fields']['name']['duplicate_merge_dom_value']='0';
$dictionary['Task']['fields']['name']['merge_filter']='disabled';
$dictionary['Task']['fields']['name']['unified_search']=false;
$dictionary['Task']['fields']['name']['calculated']='1';
$dictionary['Task']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.45',
  'searchable' => true,
);
$dictionary['Task']['fields']['name']['importable']='false';
$dictionary['Task']['fields']['name']['formula']='ifElse(equal($ayuda_asesor_cp_c,"1"),concat("AYUDA CP - ",related($leads,"name"),related($accounts,"name")),$name)';
$dictionary['Task']['fields']['name']['enforced']=false;

 ?>