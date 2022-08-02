<?php
//$GLOBALS['log']->fatal('puesto',$puesto_user);
$dependencies['Tasks']['readonly_fields'] = array
(
	'hooks' => array('all'),
	'trigger' => 'true',
	'triggerFields' => array('name','ayuda_asesor_cp_c','date_start_date','date_due'),
	'onload' => true,
	'actions' => array(
		//CRM
		array(
			'name' => 'ReadOnly',
			'params' => array
			(
				'target' => 'name',
				'value'=>'equal($ayuda_asesor_cp_c,"1")',
			),
		),
	
		array(
			'name' => 'ReadOnly',
			'params' => array
			(
				'target' => 'date_start',
				'value'=>'equal($ayuda_asesor_cp_c,"1")',
			),
		),
	),
);

$dependencies['Tasks']['readonly'] = array
(
	'hooks' => array('all'),
	'trigger' => 'true',
	'triggerFields' => array('solicitud_alta_c','subetapa_c'),
	'onload' => true,
	'actions' => array(
		array(
			'name' => 'ReadOnly',
			'params' => array
			(
				'target' => 'tasks_opportunities_1_name',
				'value'=>'or(equal($solicitud_alta_c,"1"),equal($subetapa_c,"N"))',
			),
		),
	),
);