<?php
 // created: 2019-06-07 08:39:55
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['audited']=true;
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['dependency']='or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['default']='';

 ?>