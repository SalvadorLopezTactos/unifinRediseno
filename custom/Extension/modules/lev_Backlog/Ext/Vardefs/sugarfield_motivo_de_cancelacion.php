<?php
 // created: 2018-12-05 18:17:34
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['audited'] = true;
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['dependency'] = 'or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['full_text_search']['boost'] = 1;

