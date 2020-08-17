<?php
 // created: 2020-08-17 16:08:44
$dictionary['S_seguros']['fields']['name']['unified_search']=false;
$dictionary['S_seguros']['fields']['name']['formula']='concat(related($s_seguros_accounts,"name")," - ",strToUpper(getDropdownValue("tipo_negocio_list",$tipo)))';

 ?>