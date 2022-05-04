<?php
 // created: 2022-05-03 00:25:49
$dictionary['Prospect']['fields']['codigo_expo_c']['labelValue']='Código de Expo';
$dictionary['Prospect']['fields']['codigo_expo_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Prospect']['fields']['codigo_expo_c']['enforced']='false';
$dictionary['Prospect']['fields']['codigo_expo_c']['dependency']='equal($origen_c,"18")';
$dictionary['Prospect']['fields']['codigo_expo_c']['required_formula']='equal($origen_c,"18")';
$dictionary['Prospect']['fields']['codigo_expo_c']['readonly_formula']='';

 ?>