<?php
 // created: 2018-12-05 18:17:34
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['options'] = 'tct_motivo_minuta_list';
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['dependency'] = 'equal($tct_cliente_no_interesado_chk,1)';
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['required'] = true;
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['full_text_search']['boost'] = 1;

