<?php
 // created: 2020-06-22 11:23:19
$dictionary['C5515_uni_chattigo']['fields']['name']['len']='255';
$dictionary['C5515_uni_chattigo']['fields']['name']['audited']=false;
$dictionary['C5515_uni_chattigo']['fields']['name']['massupdate']=false;
$dictionary['C5515_uni_chattigo']['fields']['name']['importable']='false';
$dictionary['C5515_uni_chattigo']['fields']['name']['duplicate_merge']='disabled';
$dictionary['C5515_uni_chattigo']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['C5515_uni_chattigo']['fields']['name']['merge_filter']='disabled';
$dictionary['C5515_uni_chattigo']['fields']['name']['unified_search']=false;
$dictionary['C5515_uni_chattigo']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['C5515_uni_chattigo']['fields']['name']['calculated']='1';
$dictionary['C5515_uni_chattigo']['fields']['name']['formula']='concat(related($accounts_c5515_uni_chattigo_1,"name"),related($leads_c5515_uni_chattigo_1,"name")," ",toString($date_entered))';
$dictionary['C5515_uni_chattigo']['fields']['name']['enforced']=true;

 ?>