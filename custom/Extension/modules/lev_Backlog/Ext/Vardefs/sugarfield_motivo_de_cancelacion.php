<?php
 // created: 2018-07-23 11:53:23
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['audited']=true;
$dictionary['lev_Backlog']['fields']['motivo_de_cancelacion']['dependency']='or(equal($estatus_de_la_operacion,"Cancelada"),equal($estatus_de_la_operacion,"Cancelada por cliente"))';

 ?>