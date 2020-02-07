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

$dependencies['Tasks']['setoptions_status_ayuda_c'] = array(
   'hooks' => array("all"),
   'trigger' => 'true',
   'triggerFields' => array('ayuda_asesor_cp_c','status'),
   'onload' => true,
   'actions' => array(
     array(
       'name' => 'SetOptions',
       'params' => array(
         'target' => 'status',
         'keys' => 'ifElse(equal($ayuda_asesor_cp_c,"1"),getDropdownKeySet("task_status_cp_list"),getDropdownKeySet("task_status_dom"))',
         'labels' => 'ifElse(equal($ayuda_asesor_cp_c,"1"),getDropdownKeySet("task_status_cp_list"),getDropdownValueSet("task_status_dom"))',
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

