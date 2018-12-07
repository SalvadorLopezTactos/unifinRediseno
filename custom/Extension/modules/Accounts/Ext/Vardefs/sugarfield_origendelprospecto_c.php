<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['origendelprospecto_c']['labelValue'] = 'Origen';
$dictionary['Account']['fields']['origendelprospecto_c']['dependency'] = 'or(equal($tipo_registro_c,"Prospecto"),equal($tipo_registro_c,"Cliente"),equal($tipo_registro_c,"Lead"))';
$dictionary['Account']['fields']['origendelprospecto_c']['visibility_grid'] = '';
$dictionary['Account']['fields']['origendelprospecto_c']['full_text_search']['boost'] = 1;

