<?php
 // created: 2019-04-15 17:19:11
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['audited'] = true;
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['default'] = 0;
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['dependency'] = 'or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';

