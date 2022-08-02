<?php
 // created: 2022-04-04 17:50:34
$dictionary['Account']['fields']['codigo_expo_c']['labelValue']='Código de Expo';
$dictionary['Account']['fields']['codigo_expo_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['codigo_expo_c']['enforced']='false';
$dictionary['Account']['fields']['codigo_expo_c']['dependency']='equal($origen_cuenta_c,"18")';
$dictionary['Account']['fields']['codigo_expo_c']['required_formula']='equal($origen_cuenta_c,"18")';
$dictionary['Account']['fields']['codigo_expo_c']['readonly_formula']='';

 ?>