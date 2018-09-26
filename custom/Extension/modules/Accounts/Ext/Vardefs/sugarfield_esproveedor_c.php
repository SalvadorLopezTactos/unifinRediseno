<?php
 // created: 2018-09-26 11:11:13
$dictionary['Account']['fields']['esproveedor_c']['labelValue']='Es Proveedor';
$dictionary['Account']['fields']['esproveedor_c']['enforced']='';
$dictionary['Account']['fields']['esproveedor_c']['dependency']='and(
not(equal($tipo_registro_c,"Lead")),not(equal($tipo_registro_c,"Persona"))
)';

 ?>
