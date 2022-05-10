<?php
 // created: 2019-04-26 09:11:00
$dictionary['Account']['fields']['nombre_comercial_c']['duplicate_merge_dom_value']=0;
$dictionary['Account']['fields']['nombre_comercial_c']['labelValue']='Nombre Comercial';
$dictionary['Account']['fields']['nombre_comercial_c']['full_text_search']=array (
  'enabled' => true,
  'boost' => '1',
  'searchable' => true,
);
$dictionary['Account']['fields']['nombre_comercial_c']['calculated']='true';
$dictionary['Account']['fields']['nombre_comercial_c']['formula']='$name';
$dictionary['Account']['fields']['nombre_comercial_c']['enforced']='';
$dictionary['Account']['fields']['nombre_comercial_c']['dependency']='not(equal($tipodepersona_c,"Persona Fisica"))';

 ?>