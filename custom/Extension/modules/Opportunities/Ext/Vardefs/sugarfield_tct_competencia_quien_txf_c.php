<?php
 // created: 2018-12-05 18:17:34
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['labelValue'] = '¿Quien?';
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['full_text_search']['enabled'] = true;
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['full_text_search']['searchable'] = false;
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['full_text_search']['boost'] = 1;
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['enforced'] = '';
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['dependency'] = 'and(
equal($tct_razon_op_perdida_ddw_c,"C"),
equal($tct_oportunidad_perdida_chk_c,true))';

