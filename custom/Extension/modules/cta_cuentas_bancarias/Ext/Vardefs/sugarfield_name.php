<?php
 // created: 2020-06-03 21:18:32
$dictionary['cta_cuentas_bancarias']['fields']['name']['len']='255';
$dictionary['cta_cuentas_bancarias']['fields']['name']['audited']=false;
$dictionary['cta_cuentas_bancarias']['fields']['name']['massupdate']=false;
$dictionary['cta_cuentas_bancarias']['fields']['name']['importable']='false';
$dictionary['cta_cuentas_bancarias']['fields']['name']['duplicate_merge']='disabled';
$dictionary['cta_cuentas_bancarias']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['cta_cuentas_bancarias']['fields']['name']['merge_filter']='disabled';
$dictionary['cta_cuentas_bancarias']['fields']['name']['unified_search']=false;
$dictionary['cta_cuentas_bancarias']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['cta_cuentas_bancarias']['fields']['name']['calculated']='1';
$dictionary['cta_cuentas_bancarias']['fields']['name']['formula']='concat(getDropdownValue("banco_list",$banco)," ",
ifElse(equal($cuenta,""),"",$cuenta),
ifElse(equal($clabe,""),"",$clabe))';
$dictionary['cta_cuentas_bancarias']['fields']['name']['enforced']=true;

 ?>