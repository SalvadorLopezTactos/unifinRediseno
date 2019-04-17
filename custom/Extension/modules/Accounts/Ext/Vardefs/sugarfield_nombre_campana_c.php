<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['nombre_campana_c']['labelValue'] = 'Nombre de la Campaña';
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['nombre_campana_c']['enforced'] = '';
$dictionary['Account']['fields']['nombre_campana_c']['dependency'] = 'equal($tct_detalle_origen_ddw_c,"Campanas")';

