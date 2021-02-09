<?php
 // created: 2021-02-04 13:36:59
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['duplicate_merge_dom_value']=0;
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['labelValue']='Tipo Cuenta';
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['calculated']='true';
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['formula']='related($s_seguros_accounts,"tipo_registro_cuenta_c")';
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['enforced']='true';
$dictionary['S_seguros']['fields']['tipo_cuenta_c']['dependency']='';

 ?>