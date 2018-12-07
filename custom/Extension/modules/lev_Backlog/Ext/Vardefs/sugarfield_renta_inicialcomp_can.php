<?php
 // created: 2018-12-05 18:17:34
$dictionary['lev_Backlog']['fields']['renta_inicialcomp_can']['audited'] = true;
$dictionary['lev_Backlog']['fields']['renta_inicialcomp_can']['default'] = 0;
$dictionary['lev_Backlog']['fields']['renta_inicialcomp_can']['dependency'] = 'or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';

