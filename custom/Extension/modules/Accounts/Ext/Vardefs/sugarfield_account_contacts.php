<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['account_contacts']['audited'] = false;
$dictionary['Account']['fields']['account_contacts']['massupdate'] = false;
$dictionary['Account']['fields']['account_contacts']['duplicate_merge'] = 'enabled';
$dictionary['Account']['fields']['account_contacts']['duplicate_merge_dom_value'] = '1';
$dictionary['Account']['fields']['account_contacts']['merge_filter'] = 'disabled';
$dictionary['Account']['fields']['account_contacts']['calculated'] = false;
$dictionary['Account']['fields']['account_contacts']['dependency'] = 'and(equal($tipodepersona_c,"Persona Moral"),equal($tipo_registro_cuenta_c,"2"))';

