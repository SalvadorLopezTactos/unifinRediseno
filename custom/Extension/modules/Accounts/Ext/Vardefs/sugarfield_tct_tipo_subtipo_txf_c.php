<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['duplicate_merge_dom_value'] = 0;
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['labelValue'] = 'Tipo y Subtipo de la Cuenta';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['calculated'] = '1';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['formula'] = 'ifElse(equal($tipo_registro_c,"Persona"),"PERSONA",ifElse(equal($tipo_registro_c,"Proveedor"),"PROVEEDOR",strToUpper(concat(getDropdownValue("tipo_registro_list",$tipo_registro_c)," ",getDropdownValue("subtipo_cuenta_list",$subtipo_cuenta_c)))))';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['enforced']='1';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['dependency']='';

 ?>
