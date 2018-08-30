<?php
<<<<<<< HEAD
 // created: 2018-08-29 16:34:34
=======
 // created: 2018-08-30 12:20:15
>>>>>>> 6482c7f3e59dcb7599cd78ce81716c1326df3196
$dictionary['Account']['fields']['nombre_comercial_c']['labelValue']='Nombre Comercial';
$dictionary['Account']['fields']['nombre_comercial_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['nombre_comercial_c']['calculated']='1';
$dictionary['Account']['fields']['nombre_comercial_c']['formula']='ifElse(
equal($nombre_comercial_c,""),
$name,
$nombre_comercial_c
)';
$dictionary['Account']['fields']['nombre_comercial_c']['enforced']='';
<<<<<<< HEAD
$dictionary['Account']['fields']['nombre_comercial_c']['dependency']='or(equal($tipodepersona_c,"Persona Moral"),equal($tipodepersona_c,"Persona Fisica con Actividad Empresarial"))';
=======
$dictionary['Account']['fields']['nombre_comercial_c']['dependency']='not(equal($tipodepersona_c,"Persona Fisica"))';
>>>>>>> 6482c7f3e59dcb7599cd78ce81716c1326df3196

 ?>