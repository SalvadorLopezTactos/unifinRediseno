<?php
 // created: 2018-02-13 17:09:26
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['audited']=true;
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['default']=0;
$dictionary['lev_Backlog']['fields']['monto_comprometido_cancelado']['dependency']='or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';

 ?>