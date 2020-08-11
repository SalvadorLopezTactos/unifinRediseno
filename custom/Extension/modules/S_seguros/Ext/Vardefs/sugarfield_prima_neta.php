<?php
 // created: 2020-08-11 11:49:32
$dictionary['S_seguros']['fields']['prima_neta']['dependency']='equal($etapa,9)';
$dictionary['S_seguros']['fields']['prima_neta']['required']=true;
$dictionary['S_seguros']['fields']['prima_neta']['importable']='false';
$dictionary['S_seguros']['fields']['prima_neta']['duplicate_merge']='disabled';
$dictionary['S_seguros']['fields']['prima_neta']['duplicate_merge_dom_value']=0;
$dictionary['S_seguros']['fields']['prima_neta']['calculated']='1';
$dictionary['S_seguros']['fields']['prima_neta']['formula']='multiply($prima_neta_ganada_c,divide($comision_c,100))';
$dictionary['S_seguros']['fields']['prima_neta']['enforced']=true;

 ?>