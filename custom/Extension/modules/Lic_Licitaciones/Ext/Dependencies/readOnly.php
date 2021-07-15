<?php

$dependencies['Lic_Licitaciones']['name'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('name'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'name', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['lic_licitaciones_accounts_name'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('lic_licitaciones_accounts_name'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'lic_licitaciones_accounts_name', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['divisa_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('divisa_c'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'divisa_c', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['monto_total'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('monto_total'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'monto_total', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['leads_lic_licitaciones_1_name'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('leads_lic_licitaciones_1_name'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'leads_lic_licitaciones_1_name', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['region'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('region'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'region', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['equipo'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('equipo'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'equipo', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['fecha_ultimo_contacto'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('fecha_ultimo_contacto'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'fecha_ultimo_contacto', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['descripcion_contrato'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('descripcion_contrato'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'descripcion_contrato', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['institucion'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('institucion'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'institucion', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['fecha_publicacion'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('fecha_publicacion'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'fecha_publicacion', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['fecha_apertura'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('fecha_apertura'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'fecha_apertura', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['fecha_inicio_contrato'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('fecha_inicio_contrato'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'fecha_inicio_contrato', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['fecha_fin_contrato'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('fecha_fin_contrato'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'fecha_fin_contrato', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['codigo_contrato_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('codigo_contrato_c'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'codigo_contrato_c', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['url_contrato_c'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('url_contrato_c'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'url_contrato_c', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);

$dependencies['Lic_Licitaciones']['assigned_user_name'] = array(
    'hooks' => array("edit"),
    'trigger' => 'true',
    'triggerFields' => array('assigned_user_name'),
    'onload' => true,
    'actions' => array(
        //Persona
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'assigned_user_name', //campo por afectar
                'value' => 'not(equal($id, ""))',
            ),
        ),
    ),
);