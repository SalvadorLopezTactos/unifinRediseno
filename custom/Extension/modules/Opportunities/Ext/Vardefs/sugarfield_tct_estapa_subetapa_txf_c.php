<?php
 // created: 2018-09-07 18:01:21
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['duplicate_merge_dom_value']=0;
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['labelValue']='Etapa y Subetapa de la Solicitud';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['calculated']='1';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['formula']='concat(getDropdownValue("tct_etapa_ddw_c_list",$tct_etapa_ddw_c)," ",getDropdownValue("estatus_c_operacion_list",$estatus_c))';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['enforced']='1';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['dependency']='';

 ?>