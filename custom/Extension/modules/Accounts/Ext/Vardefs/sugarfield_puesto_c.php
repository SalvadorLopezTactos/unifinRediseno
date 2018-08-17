<?php
 // created: 2018-07-13 12:17:37
$dictionary['Account']['fields']['puesto_c']['labelValue']='Puesto';
$dictionary['Account']['fields']['puesto_c']['dependency']='or(
equal($tipodepersona_c,"Persona Fisica"),
equal($tipodepersona_c,"Persona Fisica con Actividad Empresarial")
)';
$dictionary['Account']['fields']['puesto_c']['visibility_grid']='';

 ?>