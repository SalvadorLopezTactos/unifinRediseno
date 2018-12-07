<?php
 // created: 2018-12-05 18:17:34
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['audited'] = true;
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['default'] = 0;
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['dependency'] = 'or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';

