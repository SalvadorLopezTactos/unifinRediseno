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
			'target'=>'name',
			'label'=>'LBL_SUBJECT',
			'value'=>'ifElse(equal($ayuda_asesor_cp_c,"1"),concat("AYUDA CP - ",related($leads,"name"),related($accounts,"name")), $name)',
		),
	),
	
	array(
		'name'=>'SetValue',
		'params'=> array(
			'target'=>'date_start',
			'label'=>'LBL_START_DATE',
			'value'=>'ifElse(equal($ayuda_asesor_cp_c,"1"),today(), $date_start)',
		),
	),
	
	array(
		'name'=>'SetValue',
		'params'=> array(
			'target'=>'date_due',
			'label'=>'LBL_DUE_DATE',
			'value'=>'ifElse(equal($ayuda_asesor_cp_c,"1"),addDays(today(), 14), $date_due)',
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
