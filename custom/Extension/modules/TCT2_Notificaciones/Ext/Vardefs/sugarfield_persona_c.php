<?php
 // created: 2018-04-26 14:05:55
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['duplicate_merge_dom_value']=0;
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['labelValue']='Persona';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['calculated']='true';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['formula']='ifElse(equal(related($tct2_notificaciones_accounts,"tipo_registro_c"),"Cliente"),"Cliente","Prospecto")';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['enforced']='true';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['dependency']='';

 ?>