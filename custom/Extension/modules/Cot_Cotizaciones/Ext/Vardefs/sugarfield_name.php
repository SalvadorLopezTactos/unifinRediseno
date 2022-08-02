<?php
 // created: 2022-07-20 19:48:41
$dictionary['Cot_Cotizaciones']['fields']['name']['len']='255';
$dictionary['Cot_Cotizaciones']['fields']['name']['audited']=false;
$dictionary['Cot_Cotizaciones']['fields']['name']['massupdate']=false;
$dictionary['Cot_Cotizaciones']['fields']['name']['hidemassupdate']=false;
$dictionary['Cot_Cotizaciones']['fields']['name']['importable']='false';
$dictionary['Cot_Cotizaciones']['fields']['name']['duplicate_merge']='disabled';
$dictionary['Cot_Cotizaciones']['fields']['name']['duplicate_merge_dom_value']=0;
$dictionary['Cot_Cotizaciones']['fields']['name']['merge_filter']='disabled';
$dictionary['Cot_Cotizaciones']['fields']['name']['unified_search']=false;
$dictionary['Cot_Cotizaciones']['fields']['name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1.55',
  'searchable' => true,
);
$dictionary['Cot_Cotizaciones']['fields']['name']['calculated']='1';
$dictionary['Cot_Cotizaciones']['fields']['name']['formula']='concat("Cotización Inter - 
",related($cot_cotizaciones_s_seguros,"name"))';
$dictionary['Cot_Cotizaciones']['fields']['name']['enforced']=true;

 ?>