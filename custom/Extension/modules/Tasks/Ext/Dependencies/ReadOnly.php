<?php
global $current_user;
$puesto_user=$current_user->puestousuario_c;
if($puesto_user=='27'||$puesto_user=='31' ){
	$enabled_puesto = 'false';
}else{
	$enabled_puesto = 'true';
}

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
		
		array(
			'name' => 'ReadOnly',
			'params' => array
			(
				'target' => 'date_due',
				'value'=>'equal($ayuda_asesor_cp_c,"1")',
			),
		),
		
		array(
			'name' => 'SetVisibility',
			'params' => array
			(
				'target' => 'ayuda_asesor_cp_c',
				'value' => $enabled_puesto,
			),
		),
	),
);


//Dependencia para ocultar en Tareas la cuenta y así asignar una única a la relación Adrian Arauz 20/707/18
/*$dependencies['Tasks']['TareasNo'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
//Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('parent_name','id'),
    'onload' => true,
//Actions is a list of actions to fire when the trigger is true
// You could list multiple fields here each in their own array under 'actions'
    'actions' => array(
        array(
            'name' => 'ReadOnly',
//The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'parent_name',
                'value' => 'true',
            ),
        ),

    ),
);*/

