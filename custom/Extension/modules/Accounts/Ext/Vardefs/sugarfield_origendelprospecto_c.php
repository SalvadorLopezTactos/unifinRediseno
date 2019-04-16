<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['origendelprospecto_c']['labelValue'] = 'Origen';
$dictionary['Account']['fields']['origendelprospecto_c']['dependency'] = 'or(equal($tipo_registro_c,"Prospecto"),equal($tipo_registro_c,"Cliente"),equal($tipo_registro_c,"Lead"))';
$dictionary['Account']['fields']['origendelprospecto_c']['visibility_grid'] = '';
$dictionary['Account']['fields']['origendelprospecto_c']['full_text_search']['boost'] = 1;

