<?php
 // created: 2019-12-26 22:00:10
$dictionary['Lead']['fields']['puesto_c']['labelValue']='Puesto';
$dictionary['Lead']['fields']['puesto_c']['dependency']='or(
equal($regimen_fiscal_c,"Persona Fisica"),
equal($regimen_fiscal_c,"Persona Fisica con Actividad Empresarial")
)';
$dictionary['Lead']['fields']['puesto_c']['visibility_grid']='';

 ?>