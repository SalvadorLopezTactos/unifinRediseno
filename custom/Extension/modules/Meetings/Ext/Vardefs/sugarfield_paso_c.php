<?php
 // created: 2019-04-15 17:19:11
$dictionary['Meeting']['fields']['paso_c']['duplicate_merge_dom_value'] = 0;
$dictionary['Meeting']['fields']['paso_c']['labelValue'] = 'LBL_PASO';
$dictionary['Meeting']['fields']['paso_c']['calculated'] = '1';
$dictionary['Meeting']['fields']['paso_c']['formula'] = 'greaterThan(number(timestamp($date_start)),number(timestamp(now())))';
$dictionary['Meeting']['fields']['paso_c']['enforced'] = '1';
$dictionary['Meeting']['fields']['paso_c']['dependency'] = '';

