<?php
 // created: 2019-04-15 17:19:11
$dictionary['Account']['fields']['tct_cpld_pregunta_u2_txf_c']['labelValue'] = 'Número de Registro ante la CNBV o Condusef';
$dictionary['Account']['fields']['tct_cpld_pregunta_u2_txf_c']['full_text_search']['enabled'] = true;
$dictionary['Account']['fields']['tct_cpld_pregunta_u2_txf_c']['full_text_search']['searchable'] = true;
$dictionary['Account']['fields']['tct_cpld_pregunta_u2_txf_c']['full_text_search']['boost'] = 1;
$dictionary['Account']['fields']['tct_cpld_pregunta_u2_txf_c']['enforced'] = '';
$dictionary['Account']['fields']['tct_cpld_pregunta_u2_txf_c']['dependency'] = 'and(equal($tct_cpld_pregunta_u1_ddw_c,"Si"),equal($tipodepersona_c,"Persona Moral"))';

