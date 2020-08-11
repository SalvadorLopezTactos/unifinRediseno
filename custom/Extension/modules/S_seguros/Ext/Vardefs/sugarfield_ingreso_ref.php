<?php
 // created: 2020-08-11 11:59:00
$dictionary['S_seguros']['fields']['ingreso_ref']['dependency']='equal($etapa,9)';
$dictionary['S_seguros']['fields']['ingreso_ref']['formula']='multiply($prima_neta,divide($incentivo,100))';

 ?>