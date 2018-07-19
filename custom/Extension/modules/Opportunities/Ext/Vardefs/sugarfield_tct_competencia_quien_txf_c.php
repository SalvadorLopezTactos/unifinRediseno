<?php
 // created: 2018-07-18 14:42:43
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['labelValue']='¿Quien?';
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['enforced']='';
$dictionary['Opportunity']['fields']['tct_competencia_quien_txf_c']['dependency']='and(
equal($tct_razon_op_perdida_ddw_c,"C"),
equal($tct_oportunidad_perdida_chk_c,true))';

 ?>