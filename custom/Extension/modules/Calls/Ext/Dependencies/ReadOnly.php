<?php

/*@Jesus Carrillo
    Dependencias en base al resultado de llamadas
*/
$dependencies['Calls']['ResultadoCalls'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('tct_resultado_llamada_ddw_c','id'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    // You could list multiple fields here each in their own array under 'actions'
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_resultado_llamada_ddw_c',
                'value' => 'not(equal($id,""))',
            ),
        ),

    ),
);
$dependencies['Calls']['MotivoIlocalizable'] = array(
        'hooks' => array("edit"),
        'triggerFields' => array('tct_resultado_llamada_ddw_c'),
        'onload' => true,
        //Actions is a list of actions to fire when the trigger is true
        'actions' => array(
            array(
                'name' => 'SetVisibility',
                'params' => array(
                    'target' => 'tct_motivo_ilocalizable_ddw_c',
                    'value' => 'equal($tct_resultado_llamada_ddw_c,"Ilocalizable")',
                ),
            ),
            array(
                'name' => 'ReadOnly',
                //The parameters passed in will depend on the action type set in 'name'
                'params' => array(
                    'target' => 'tct_motivo_ilocalizable_ddw_c',
                    'value' => 'not(equal($id,""))',
                ),
            ),
        ),
    );
$dependencies['Calls']['MotivoDesinteres'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_motivo_desinteres_ddw_c',
                'value' => 'equal($tct_resultado_llamada_ddw_c,"No_esta_Interesado")',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_motivo_desinteres_ddw_c',
                'value' => 'not(equal($id,""))',
            ),
        ),
    ),
);
$dependencies['Calls']['FechaCita'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_fecha_cita_dat_c',
                'value' => 'equal($tct_resultado_llamada_ddw_c,"Cita")',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_fecha_cita_dat_c',
                'value' => 'not(equal($id,""))',
            ),
        ),
    ),
);
$dependencies['Calls']['FechaSeguimiento'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_fecha_seguimiento_dat_c',
                'value' => 'equal($tct_resultado_llamada_ddw_c,"Seguimiento")',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_fecha_seguimiento_dat_c',
                'value' => 'not(equal($id,""))',
            ),
        ),
    ),
);
$dependencies['Calls']['UsuarioCita'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'tct_usuario_cita_rel_c',
                'value' => 'equal($tct_resultado_llamada_ddw_c,"Cita")',
            ),
        ),
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_usuario_cita_rel_c',
                'value' => 'not(equal($id,""))',
            ),
        ),
    ),
);