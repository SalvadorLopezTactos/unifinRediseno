<?php
 // created: 2021-07-09 16:29:17
$dictionary['S_seguros']['fields']['prima_neta']['dependency']='or(equal($subetapa_c,1),equal($subetapa_c,2))';
$dictionary['S_seguros']['fields']['prima_neta']['required']=true;
$dictionary['S_seguros']['fields']['prima_neta']['importable']='false';
$dictionary['S_seguros']['fields']['prima_neta']['duplicate_merge']='disabled';
$dictionary['S_seguros']['fields']['prima_neta']['duplicate_merge_dom_value']=0;
$dictionary['S_seguros']['fields']['prima_neta']['calculated']='1';
$dictionary['S_seguros']['fields']['prima_neta']['formula']='multiply($prima_neta_emitida_c,divide($comision_c,100))';
$dictionary['S_seguros']['fields']['prima_neta']['enforced']=true;
$dictionary['S_seguros']['fields']['prima_neta']['audited']=true;

 ?>