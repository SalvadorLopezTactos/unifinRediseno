<?php
 // created: 2022-05-25 19:21:52
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['duplicate_merge_dom_value']=0;
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['labelValue']='Etapa Solicitud';
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['calculated']='1';
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['formula']='concat(
ifElse(
	isInList($etapa_c,createList("1","2","3","4","5")),
	getDropdownValue("etapa_c_list",$etapa_c),""
)," ",
ifElse(
	equal($etapa_c,"1"),
	getDropdownValue("progreso_list",$progreso),""
)
)';
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['enforced']='1';
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['dependency']='';
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['required_formula']='';
$dictionary['lev_Backlog']['fields']['etapa_solicitud_c']['readonly_formula']='';

 ?>