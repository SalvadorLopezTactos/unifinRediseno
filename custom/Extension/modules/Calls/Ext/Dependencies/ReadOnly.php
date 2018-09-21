<?php

/*
 AF - 2018/09/14
 Bloquea campos cuando estado es; Realizada o No realizada
*/
$dependencies['Calls']['readOnly_Held_NotHeld'] = array
(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('created_by','description','status'),
    'onload' => true,
    'actions' => array(
        //Botón Editar
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Asunto
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'name',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        // Conferencia
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tct_conferencia_chk_c',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Fecha inicio
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'date_start',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Fecha fin
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'date_end',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Repetir
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'repeat_type',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Dirección
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'direction',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Recordatorio
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'reminder_time',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Email
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'email_reminder_time',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Descripción
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'description',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //Invitados
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'invitees',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //follow
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'follow',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
        //team_name
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'team_name',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),

    ),
    'notActions' => array(),

);

/*@Jesus Carrillo
    Dependencias en base al resultado de llamadas
*/
$dependencies['Calls']['ResultadoCalls'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('tct_resultado_llamada_ddw_c','id','tct_conferencia_chk_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    // You could list multiple fields here each in their own array under 'actions'
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_resultado_llamada_ddw_c',
                'value' => '$tct_conferencia_chk_c',
            ),
        ),
    ),
);
$dependencies['Calls']['MotivoIlocalizable'] = array(
        'hooks' => array("edit"),
        'triggerFields' => array('tct_resultado_llamada_ddw_c','status','id'),
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
            /*array(
                'name' => 'ReadOnly',
                //The parameters passed in will depend on the action type set in 'name'
                'params' => array(
                    'target' => 'tct_motivo_ilocalizable_ddw_c',
                    'value' => 'and(not(equal($id,"")),not(equal($tct_resultado_llamada_ddw_c,"")),not(equal($status,"Planned")))',
                ),
            ),*/
        ),
    );
$dependencies['Calls']['MotivoDesinteres'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c','status','id'),
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
        /*array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_motivo_desinteres_ddw_c',
                'value' => 'and(not(equal($id,"")),not(equal($tct_resultado_llamada_ddw_c,"")),not(equal($status,"Planned")))',
            ),
        ),*/
    ),
);
$dependencies['Calls']['FechaCita'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c','status','id'),
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
        /*array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_fecha_cita_dat_c',
                'value' => 'and(not(equal($id,"")),not(equal($tct_resultado_llamada_ddw_c,"")),not(equal($status,"Planned")))',
            ),
        ),*/
    ),
);
$dependencies['Calls']['FechaSeguimiento'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c','status','id'),
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
        /*array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_fecha_seguimiento_dat_c',
                'value' => 'and(not(equal($id,"")),not(equal($tct_resultado_llamada_ddw_c,"")),not(equal($status,"Planned")))',
            ),
        ),*/
    ),
);
$dependencies['Calls']['UsuarioCita'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('tct_resultado_llamada_ddw_c','status','id'),
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
        /*array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'tct_usuario_cita_rel_c',
                'value' => 'and(not(equal($id,"")),not(equal($tct_resultado_llamada_ddw_c,"")),not(equal($status,"Planned")))',
            ),
        ),*/
    ),
);
