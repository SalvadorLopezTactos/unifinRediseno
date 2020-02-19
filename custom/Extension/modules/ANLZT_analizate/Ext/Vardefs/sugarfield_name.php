<?php
 // created: 2020-02-19 17:44:06
$dictionary['ANLZT_analizate']['fields']['name']['len']='255';
$dictionary['ANLZT_analizate']['fields']['name']['audited']=false;
$dictionary['ANLZT_analizate']['fields']['name']['massupdate']=false;
$dictionary['ANLZT_analizate']['fields']['name']['importable']='false';
$dictionary['ANLZT_analizate']['fields']['name']['duplicate_merge']='disabled';
$dictionary['ANLZT_analizate']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['ANLZT_analizate']['fields']['name']['merge_filter']='disabled';
$dictionary['ANLZT_analizate']['fields']['name']['unified_search']=false;
$dictionary['ANLZT_analizate']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['ANLZT_analizate']['fields']['name']['calculated']='true';
$dictionary['ANLZT_analizate']['fields']['name']['formula']='concat($tipo,$estado,$documento)';
$dictionary['ANLZT_analizate']['fields']['name']['enforced']=true;

 ?>