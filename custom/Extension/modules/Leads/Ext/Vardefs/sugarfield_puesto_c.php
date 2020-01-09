<?php
 // created: 2020-01-06 18:50:48
$dictionary['Lead']['fields']['puesto_c']['labelValue']='Puesto';
$dictionary['Lead']['fields']['puesto_c']['dependency']='or(
equal($regimen_fiscal_c,"Persona Fisica"),
equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial")
)';
$dictionary['Lead']['fields']['puesto_c']['visibility_grid']='';

 ?>