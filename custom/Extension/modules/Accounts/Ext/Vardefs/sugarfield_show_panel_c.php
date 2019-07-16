<?php
 // created: 2019-07-16 18:38:51
$dictionary['Account']['fields']['show_panel_c']['duplicate_merge_dom_value']=0;
$dictionary['Account']['fields']['show_panel_c']['labelValue']='Muestra panel';
$dictionary['Account']['fields']['show_panel_c']['calculated']='1';
$dictionary['Account']['fields']['show_panel_c']['formula']='ifElse(
or(
equal($tipo_registro_c,"Lead"),
equal($tipo_registro_c,"Prospecto"),
equal($tipo_registro_c,"Cliente"),
equal($tipo_registro_c,"Proveedor")
),
true,
false
)';
$dictionary['Account']['fields']['show_panel_c']['enforced']='1';
$dictionary['Account']['fields']['show_panel_c']['dependency']='';

 ?>