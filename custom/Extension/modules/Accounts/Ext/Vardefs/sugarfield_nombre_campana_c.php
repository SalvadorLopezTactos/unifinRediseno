<?php
 // created: 2018-06-20 12:35:53
$dictionary['Account']['fields']['nombre_campana_c']['labelValue']='Nombre de la Campaña';
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Account']['fields']['nombre_campana_c']['enforced']='';
$dictionary['Account']['fields']['nombre_campana_c']['dependency']='equal($tct_detalle_origen_ddw_c,"Campanas")';

 ?>