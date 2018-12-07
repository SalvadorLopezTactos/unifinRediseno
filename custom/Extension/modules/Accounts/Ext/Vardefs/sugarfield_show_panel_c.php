<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['show_panel_c']['duplicate_merge_dom_value'] = 0;
$dictionary['Account']['fields']['show_panel_c']['labelValue'] = 'Muestra panel';
$dictionary['Account']['fields']['show_panel_c']['calculated'] = 'true';
$dictionary['Account']['fields']['show_panel_c']['formula'] = 'ifElse(
or(
equal($tipo_registro_c,"Lead"),
equal($tipo_registro_c,"Prospecto"),
equal($tipo_registro_c,"Cliente")
),
true,
false
)';
$dictionary['Account']['fields']['show_panel_c']['enforced'] = 'true';
$dictionary['Account']['fields']['show_panel_c']['dependency'] = '';

