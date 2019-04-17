<?php
 // created: 2019-04-15 17:19:11
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['duplicate_merge_dom_value'] = 0;
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['labelValue'] = 'Persona';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['full_text_search']['enabled'] = true;
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['full_text_search']['searchable'] = true;
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['full_text_search']['boost'] = 1;
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['calculated'] = 'true';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['formula'] = 'ifElse(equal(related($tct2_notificaciones_accounts,"tipo_registro_c"),"Cliente"),"Cliente","Prospecto")';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['enforced'] = 'true';
$dictionary['TCT2_Notificaciones']['fields']['persona_c']['dependency'] = '';

