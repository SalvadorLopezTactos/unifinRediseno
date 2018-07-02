<?php
 // created: 2018-02-16 16:59:02
$dictionary['Account']['fields']['account_contacts']['audited'] = false;
$dictionary['Account']['fields']['account_contacts']['massupdate'] = false;
$dictionary['Account']['fields']['account_contacts']['duplicate_merge'] = 'enabled';
$dictionary['Account']['fields']['account_contacts']['duplicate_merge_dom_value'] = '1';
$dictionary['Account']['fields']['account_contacts']['merge_filter'] = 'disabled';
$dictionary['Account']['fields']['account_contacts']['calculated'] = false;
$dictionary['Account']['fields']['account_contacts']['dependency'] = 'and(
equal($tipodepersona_c,"Persona Moral"),
equal($tipo_registro_c,"Prospecto")
)';

