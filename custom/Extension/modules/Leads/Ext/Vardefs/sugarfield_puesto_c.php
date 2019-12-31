<?php
 // created: 2019-12-31 16:08:06
$dictionary['Lead']['fields']['puesto_c']['labelValue']='Puesto';
$dictionary['Lead']['fields']['puesto_c']['dependency']='or(
equal($regimen_fiscal_c,"Persona Fisica"),
equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial")
)';
 ?>
