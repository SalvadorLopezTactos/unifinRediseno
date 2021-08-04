<?php
 // created: 2021-07-13 16:56:36
$dictionary['S_seguros']['fields']['incentivo']['default']='25';
$dictionary['S_seguros']['fields']['incentivo']['audited']=true;
$dictionary['S_seguros']['fields']['incentivo']['required']=true;
$dictionary['S_seguros']['fields']['incentivo']['dependency']='or(equal($subetapa_c,1),equal($subetapa_c,2))';

 ?>
