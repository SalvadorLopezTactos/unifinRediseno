<?php
 // created: 2019-04-15 17:19:11
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

