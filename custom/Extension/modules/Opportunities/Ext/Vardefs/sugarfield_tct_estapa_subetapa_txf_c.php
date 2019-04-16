<?php
 // created: 2019-04-15 17:19:11
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['duplicate_merge_dom_value'] = 0;
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['labelValue'] = 'Etapa y Subetapa de la Solicitud';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['full_text_search']['enabled'] = true;
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['full_text_search']['searchable'] = true;
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['full_text_search']['boost'] = 1;
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['calculated'] = '1';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['formula'] = 'concat(getDropdownValue("tct_etapa_ddw_c_list",$tct_etapa_ddw_c)," ",getDropdownValue("estatus_c_operacion_list",$estatus_c))';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['enforced'] = '1';
$dictionary['Opportunity']['fields']['tct_estapa_subetapa_txf_c']['dependency'] = '';

