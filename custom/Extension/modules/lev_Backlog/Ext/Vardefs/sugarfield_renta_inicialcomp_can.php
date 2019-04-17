<?php
 // created: 2019-04-15 17:19:11
$dictionary['lev_Backlog']['fields']['renta_inicialcomp_can']['audited'] = true;
$dictionary['lev_Backlog']['fields']['renta_inicialcomp_can']['default'] = 0;
$dictionary['lev_Backlog']['fields']['renta_inicialcomp_can']['dependency'] = 'or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';

