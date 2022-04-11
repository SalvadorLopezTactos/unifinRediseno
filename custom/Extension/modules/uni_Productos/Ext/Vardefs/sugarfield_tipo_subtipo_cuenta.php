<?php
 // created: 2022-04-11 17:07:01
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['hidemassupdate']=false;
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['importable']='false';
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['duplicate_merge']='disabled';
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['duplicate_merge_dom_value']=0;
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['calculated']='true';
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['formula']='ifElse(equal($tipo_cuenta,"4"),"PERSONA",ifElse(equal($tipo_cuenta,"5"),"PROVEEDOR",strToUpper(concat(getDropdownValue("tipo_registro_cuenta_list",$tipo_cuenta)," ",getDropdownValue("subtipo_registro_cuenta_list",$subtipo_cuenta)))))';
$dictionary['uni_Productos']['fields']['tipo_subtipo_cuenta']['enforced']=true;

 ?>