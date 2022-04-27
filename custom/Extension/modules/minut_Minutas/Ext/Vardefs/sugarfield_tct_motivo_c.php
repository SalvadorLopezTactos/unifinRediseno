<?php
 // created: 2019-04-15 17:19:11
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['options'] = 'tct_motivo_minuta_list';
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['dependency'] = 'equal($tct_cliente_no_interesado_chk,1)';
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['required'] = true;
$dictionary['minut_Minutas']['fields']['tct_motivo_c']['full_text_search']['boost'] = 1;

