<?php
 // created: 2020-05-04 19:58:08
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['duplicate_merge_dom_value']=0;
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['labelValue']='Tipo y Subtipo de la Cuenta';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['calculated']='1';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['formula']='ifElse(equal($tipo_registro_cuenta_c,"4"),"PERSONA",ifElse(equal($tipo_registro_cuenta_c,"5"),"PROVEEDOR",strToUpper(concat(getDropdownValue("tipo_registro_cuenta_list",$tipo_registro_cuenta_c)," ",getDropdownValue("subtipo_registro_cuenta_list",$subtipo_registro_cuenta_c)))))';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['enforced']='1';
$dictionary['Account']['fields']['tct_tipo_subtipo_txf_c']['dependency']='';

 ?>