<?php
 // created: 2018-12-05 18:17:34
$dictionary['Account']['fields']['nombre_campana_c']['labelValue'] = 'Nombre de la Campaña';
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']['searchable'] = false;
$dictionary['Account']['fields']['nombre_campana_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['nombre_campana_c']['enforced'] = '';
$dictionary['Account']['fields']['nombre_campana_c']['dependency'] = 'equal($tct_detalle_origen_ddw_c,"Campanas")';

