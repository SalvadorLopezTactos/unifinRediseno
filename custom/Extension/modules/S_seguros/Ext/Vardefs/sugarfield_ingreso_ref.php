<?php
 // created: 2021-07-22 10:27:58
$dictionary['S_seguros']['fields']['ingreso_ref']['dependency']='or(equal($subetapa_c,1),equal($subetapa_c,2))';
$dictionary['S_seguros']['fields']['ingreso_ref']['formula']='multiply($prima_neta,divide($incentivo,100))';
$dictionary['S_seguros']['fields']['ingreso_ref']['audited']=true;

 ?>