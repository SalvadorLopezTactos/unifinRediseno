<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/23/2016
 * Time: 4:52 PM
 */

$dependencies['uni_Brujula']['name_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'name',
                'label' => 'name_label',
                'value' => 'true',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['assigned_user_name_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'assigned_user_name',
                'label' => 'assigned_user_name_label',
                'value' =>  'not(equal(assigned_user_name, ""))',
                //'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['fecha_reporte_readonly'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'fecha_reporte',
                'label' => 'fecha_reporte_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['vacaciones'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'vacaciones_c',
                'label' => 'vacaciones_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

//Contactos/llamadas
$dependencies['uni_Brujula']['contactos_numero'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_numero',
                'label' => 'contactos_numero_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);
$dependencies['uni_Brujula']['contactos_duracion'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_duracion',
                'label' => 'contactos_duracion_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

//Resultados
$dependencies['uni_Brujula']['contactos_no_localizados'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_no_localizados',
                'label' => 'contactos_no_localizados_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['contactos_no_interesados'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_no_interesados',
                'label' => 'contactos_no_interesados_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['contactos_seguimiento_futuro'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_seguimiento_futuro',
                'label' => 'contactos_seguimiento_futuro_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['contactos_siguiente_llamada'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_siguiente_llamada',
                'label' => 'contactos_siguiente_llamada_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['contactos_por_visitar'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_por_visitar',
                'label' => 'contactos_por_visitar_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['contactos_enviaran_informacion'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'contactos_enviaran_informacion',
                'label' => 'contactos_enviaran_informacion_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);


//Citas
$dependencies['uni_Brujula']['tct_uni_citas_txf_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tct_uni_citas_txf_c',
                'label' => 'tct_uni_citas_txf_c_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

//Tiempos
$dependencies['uni_Brujula']['tiempo_prospeccion'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_prospeccion',
                'label' => 'tiempo_prospeccion_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_revision_expediente_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_revision_expediente_c',
                'label' => 'tiempo_revision_expediente_c_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_armado_expedientes'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_armado_expedientes',
                'label' => 'tiempo_armado_expedientes_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_seguimiento_expedientes'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_seguimiento_expedientes',
                'label' => 'tiempo_seguimiento_expedientes_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_operacion'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_operacion',
                'label' => 'tiempo_operacion_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_liberacion'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_liberacion',
                'label' => 'tiempo_liberacion_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_servicio_cliente'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_servicio_cliente',
                'label' => 'tiempo_servicio_cliente_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['uni_Brujula']['tiempo_otras_actividades'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'tiempo_otras_actividades',
                'label' => 'tiempo_otras_actividades_label',
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);
