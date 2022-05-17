<?php
 // created: 2021-08-26 12:23:24
$dictionary['Account']['fields']['alianza_soc_chk_c']['duplicate_merge_dom_value']=0;
$dictionary['Account']['fields']['alianza_soc_chk_c']['labelValue']='Alianza SOC';
$dictionary['Account']['fields']['alianza_soc_chk_c']['calculated']='1';
$dictionary['Account']['fields']['alianza_soc_chk_c']['formula']='ifElse(and(equal($origen_cuenta_c,"12"),equal($detalle_origen_c,"12")),true,$alianza_soc_chk_c)';
$dictionary['Account']['fields']['alianza_soc_chk_c']['enforced']='1';
$dictionary['Account']['fields']['alianza_soc_chk_c']['dependency']='not(and(equal($origen_cuenta_c,"12"),equal($detalle_origen_c,"12")))';

 ?>