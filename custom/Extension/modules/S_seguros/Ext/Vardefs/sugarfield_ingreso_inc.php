<?php
 // created: 2020-07-31 14:37:19
$dictionary['S_seguros']['fields']['ingreso_inc']['importable']='false';
$dictionary['S_seguros']['fields']['ingreso_inc']['duplicate_merge']='disabled';
$dictionary['S_seguros']['fields']['ingreso_inc']['duplicate_merge_dom_value']=0;
$dictionary['S_seguros']['fields']['ingreso_inc']['calculated']='true';
$dictionary['S_seguros']['fields']['ingreso_inc']['formula']='multiply($prima_obj_c,divide($incentivo,100))';
$dictionary['S_seguros']['fields']['ingreso_inc']['enforced']=true;

 ?>