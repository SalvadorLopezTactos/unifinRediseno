<?php
$dependencies['Tasks']['ayuda_asesor_cp_c']= array
(
    'hooks'=> array('all'),
    'trigger'=>'true',
    'triggerFields'=> array('name','ayuda_asesor_cp_c','date_start_date','date_start','date_due'),
    'onload'=> true,
    'actions'=> array(
	
	array(
		'name'=>'SetValue',
		'params'=> array(
			'target'=>'date_start',
			'label'=>'LBL_START_DATE',
			'value'=>'ifElse(equal($date_start,""),now(), $date_start)',
		),
	),
	
	array(
		'name'=>'SetValue',
		'params'=> array(
			'target'=>'date_due',
			'label'=>'LBL_DUE_DATE',
			'value'=>'ifElse(equal($ayuda_asesor_cp_c,"1"),ifElse(equal($date_due,""),addDays(now(), 14), $date_due), ifElse(not(equal($date_due,"")),$date_due,""))',
		),
	),
	
    //Limpia entidad federativa cuando no vive en México y cuando es PM
    //array(
    //    'name'=>'SetValue',
    //    'params'=> array(
    //        'target'=>'name',
    //        'label'=>'LBL_TCT_ENTIDADFEDERATIVA_D_C',
    //        'value'=>'ifElse(not(equal($ayuda_asesor_cp_c,"1")),$tct_entidadfederativa_d_c,"")',
    //    ),
    //),
  ),
);

$dependencies['Tasks']['atrasada']= array
(
    'hooks'=> array('all'),
    'trigger'=>'true',
    'triggerFields'=> array('ayuda_asesor_cp_c','status'),
    'onload'=> true,
    'actions'=> array(	
		array(
			'name'=>'SetValue',
			'params'=> array(
				'target'=>'atrasada_c',
				'label'=>'LBL_ATRASADA',
				'value'=>'ifElse(and($ayuda_asesor_cp_c,equal($status,"Atrasada")),"Ayuda Atrasada",ifElse(and($ayuda_asesor_cp_c,not(equal($status,"Atrasada"))),"Ayuda",ifElse(and(not($ayuda_asesor_cp_c),equal($status,"Atrasada")),"Atrasada","")))',
			),
		),
    ),
);

$dependencies['Tasks']['solicitud']= array
(
    'hooks'=> array('all'),
    'trigger'=>'true',
    'triggerFields'=> array('potencial_negocio_c'),
    'onload'=> true,
    'actions'=> array(	
		array(
			'name'=>'SetValue',
			'params'=> array(
				'target'=>'tasks_opportunities_1opportunities_idb',
				'value'=>'ifElse(equal($potencial_negocio_c,2),"",$tasks_opportunities_1opportunities_idb)',
			),
		),
    ),
);